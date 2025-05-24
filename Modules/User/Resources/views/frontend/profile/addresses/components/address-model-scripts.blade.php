<script>
    function openAddressModal(address = null){

        let itemId = `#addressModel`;
        if(address != null){

            address = JSON.parse(address);
            itemId = `#addressModel${address.id}`;
        }
        

        if(address && address.hasOwnProperty('json_data') && address.json_data){
            if(address.json_data.hasOwnProperty('country_id')){

                let model = $(itemId);
                let countrySelector = model.find('.country_selector');
                countrySelector.val(address.json_data.country_id);
                getCitiesByCountryId(countrySelector,address.state_id);
            }
        }

        $('.select-detail, .select2').select2({

            dropdownParent: $(itemId)
        });

        $(itemId).modal('show');
    }

    function getStatesByCityId(state_id_selector, city_id_selector) {

        state_id_selector = $('#' + state_id_selector);
        state_id_selector.empty();

        var container = state_id_selector.closest('.state_container');
        container.find('.state_selector_content').hide();
        container.find('.state_selector_content_loader').show();
        var id = $('#' + city_id_selector).val();

        $.ajax({
            method: "GET",
            url: '{{route('frontend.area.get_child_area_by_parent')}}?type=state&parent_id=' + id,
            success: function (data) {
                
                var option = '';
                $.each(data.data, function (index, state) {
                    option = '<option value="' + state.id + '">' + state.title + '</option>';
                    state_id_selector.append(option);
                });
                container.find('.state_selector_content').show();
                container.find('.state_selector_content_loader').hide();
            }
        });
    }

    function getCitiesByCountryId(country,selectedVal = null) {

        country = $(country);
        var container = country.closest('.address_selector');
        var area_selector = container.find('.area_selector');
        var id = country.val();

        if (id != '') {
            $.ajax({
                method: "GET",
                url: '{{route('frontend.area.get_child_area_by_parent')}}?type=city&parent_id=' + id,
                beforeSend: function () {
                    area_selector.empty();
                    container.find('.state_selector_content').hide();
                    container.find('.state_selector_content_loader').show();
                },
                success: function (data) {
                    defaultSelected = !selectedVal ? 'selected' : '';
                    area_selector.append('<option '+defaultSelected+' selected value="">{{__('user::frontend.addresses.form.states')}}</option>');
                    var optgroup = '';
                    $.each(data.data, function (index, city) {
                        var options = '';
                        $.each(city.states, function (index, state) {
                            selected = selectedVal && selectedVal == state.id ? 'selected' : '';
                            options += '<option value="' + state.id + '" data-title="' + state.data_title + '" '+selected+'>' + state.title + '</option>';
                        });

                        optgroup = '<optgroup label="'+city.title+'">'+options+'</optgroup>';
                        area_selector.append(optgroup);
                    });
                    container.find('.state_selector_content').show();
                    container.find('.state_selector_content_loader').hide();
                    var form = container.closest("form");
                    var block_container = form.find(".block_container");
                    if(data.country === 'KW'){
                        block_container.show();
                    }else{

                        block_container.hide();
                    }

                    @if(auth()->check())
                        $('.select-detail, .select2, .area_selector').select2({

                            dropdownParent: country.closest('.modal').first()
                        });
                    @endif
                }
            });
        }
    }

    function cityChanged(city) {

        var optionSelected = $("option:selected", city);
        let title = optionSelected.attr('data-title');
        let id = optionSelected.attr('value');
        let state_selector_content = $(city).closest('.state_selector_content').first();
        
        if(state_selector_content){
            state_selector_content.find('.city_name').first().val(title);
            state_selector_content.find('.state_id').first().val(id);
        }
    }
</script>