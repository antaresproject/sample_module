$(document).ready(function () {

    $('.main-content').on('click', '.filter-container .form-block button:submit', function (e) {
        var handler = $(this);
        var data = handler.closest('form').serializeArray();
        var from = handler.closest('.filter-container');
        var route = $('.filter-group-route').val();
        var column = from.find('.filter-group-column').val();
        var classname = from.find('.classname').val();
        var container = handler.closest('.ddown-multi__submenu');
        container.LoadingOverlay('show');
        var table = handler.closest('.tbl-c').find('[data-table-init]');
        $.ajax({
            url: $('input.datatables-filter-store').val(),
            data: {
                route: route,
                classname: classname,
                params: {
                    column: column,
                    value: data
                }
            },
            type: 'POST',
            success: function (response) {
                $('.card-filter').append(response);
                table.dataTable().api().draw();
                container.LoadingOverlay('hide');
            },
            complete: function () {
                container.LoadingOverlay('hide');
            }
        });
        return false;
    });
    function inlineFilter(element) {
        var $ul = $(element).closest('.ddown__menu');
        var container = $(element).closest('.ddown--filter-edit');
        var handler = container.find('.datatables-card-filter');
        var self = $(element);
        var table = self.closest('.tbl-c').find('[data-table-init]');
        var newValue = self.closest('form').serializeArray();
        $ul.LoadingOverlay('show');
        $.ajax({
            url: $('input.datatables-filter-update').val(),
            data: {
                column: handler.attr('column'),
                serialized: handler.attr('value'),
                new : newValue
            },
            type: 'POST',
            success: function (response) {
                self.closest('.ddown--filter-edit').replaceWith(response);
                table.dataTable().api().draw();
            },
            complete: function (error) {
                $ul.LoadingOverlay('hide');
            }
        });
    }

    $('.card-filter .ddown__content .form-block button:submit').on('click', function (e) {
        e.preventDefault();
        inlineFilter(this);
        return false;
    });
    $('.main-content').on('click', '.ddown__content .form-block button:submit', function (e) {
        e.preventDefault();
        inlineFilter(this);
        return false;
    });

});
