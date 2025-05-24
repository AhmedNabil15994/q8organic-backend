<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\DriverApp\Transformers\WebService\OrderResource;
use Modules\DriverApp\Repositories\WebService\OrderRepository as Order;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\DriverApp\Repositories\WebService\UserRepository as User;
use Modules\DriverApp\Transformers\WebService\DriverUserResource;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;
use Modules\Order\Mail\Dashboard\UpdateOrderStatusMail;
use Tocaan\FcmFirebase\Facades\FcmFirebase;

class OrderController extends WebServiceController
{
    use SendNotification;

    protected $order;
    protected $notification;
    protected $user;

    function __construct(Order $order, Notification $notification, User $user)
    {
        $this->order = $order;
        $this->notification = $notification;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $orders = $this->order->getAllByDriver();
        return $this->response(OrderResource::collection($orders));
    }

    public function show(Request $request, $id)
    {
        $order = $this->order->findOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        return $this->response(new OrderResource($order));
    }

    public function updateOrderByDriver(Request $request, $id)
    {
        $order = $this->order->findOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        $check = $this->order->updateOrderByDriver($order, $request, $id);
        if ($check)
            return $this->response(null);
        else
            return $this->error(__('driver_app::orders.driver.oops_error'), [], 401);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = $this->order->findOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        $check = $this->order->updateOrderStatus($order, $request);
        if ($check) {
            // Start Send E-mail & Push Notification To Mobile App Users & Drivers
            $this->sendNotification($order);
            return $this->response(null);
        } else
            return $this->error(__('driver_app::orders.driver.oops_error'), [], 401);
    }

    public function assignOrderToDriver(Request $request, $id)
    {
        $order = $this->order->findOrderById($id);
        if (!$order)
            return $this->error(__('driver_app::orders.driver.order_not_found'), [], 401);

        $driver = $this->user->findById($request->driver_id);
        if (!$driver)
            return $this->error(__('driver_app::orders.driver.driver_not_found'), [], 401);

        $check = $this->order->assignOrderToDriver($order, $request);
        if ($check) {
            if (!is_null(optional($order->driver)->user)) { // admin send notification to driver
                $this->sendMobileNotify($order, $order->driver->user->id);
            }
            return $this->response(null);
        } else
            return $this->error(__('driver_app::orders.driver.oops_error'), [], 401);
    }

    public function sendNotification($order)
    {
        if (!is_null($order->user_id)) { // send notification to user
            $this->sendMobileNotify($order, $order->user_id);
            /*$userEmail = $order->user->email ?? null;
            if (!is_null($userEmail))
                $this->sendEmailNotify($order, $userEmail);*/
        }

        if (!auth('api')->user()->can('driver_access') && !is_null(optional($order->driver)->user)) { // admin send notification to driver
            $this->sendMobileNotify($order, $order->driver->user->id);
            /*$driverEmail = $order->driver->user->email ?? null;
            if (!is_null($driverEmail))
                $this->sendEmailNotify($order, $driverEmail);*/
        }

        if (auth('api')->user()->can('driver_access')) { // driver send notification to admin
            $admins = $this->user->getAllAdmins();
            foreach ($admins as $admin) {
                $this->sendMobileNotify($order, $admin->id);
                /*if (!is_null($admin->email))
                    $this->sendEmailNotify($order, $admin->email);*/
            }
        }
        return true;
    }

    public function sendMobileNotify($order, $userId)
    {
        $tokens = $this->notification->getAllUserTokens($userId);
        $locale = app()->getLocale();
        if (count($tokens) > 0) {
            $data = [
                'title' => __('order::dashboard.orders.notification.title'),
                'body' => __('order::dashboard.orders.notification.body') . ' - ' . $order->orderStatus->title,
                'type' => 'order',
                'id' => $order->id,
            ];
//            $this->send($data, $tokens);
            FcmFirebase::sendForUser(\Modules\User\Entities\User::find($userId),$data);

        }
        return true;
    }

    public function sendEmailNotify($order, $email)
    {
        \Mail::to($email)->send(new UpdateOrderStatusMail($order));
        return true;
    }

    public function getDriversList(Request $request)
    {
        $drivers = $this->user->getAllDrivers();
        return $this->response(DriverUserResource::collection($drivers));
    }
}
