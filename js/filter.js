/**
 * function to search into the table
 */
$(document).ready(function(){

    $('.search').on('click',function(e){
        /* Useful DOM data and selectors */
        var inputContent = [];
        //get all filters input and values
        $('.filters').find('th').each(function(index){
            var $input = $(this).find('input'),
            column = $('.filters th').index(this);
            if(typeof $input.val() != 'undefined') inputContent[column] = $input.val().toLowerCase();
        });
        var $table = $('.table'),
            $rows = $table.find('tbody tr');

        /* Dirtiest filter function ever, needs time to improve, but it works! ;) */
        var $filteredRows = $rows.filter(function(){
            var $row = $(this);
            var notMatch = false;
            for(var column in inputContent) {
                var value = $row.find('td').eq(column).text().toLowerCase();
                notMatch = value.indexOf(inputContent[column]) === -1; //compare input and column values
                if(notMatch) break; //if some input doesn't match with row's content, break the loop
            }
            return notMatch; //returns true (if row's content doesn't match with filter) or false (if it's a match =D )
        });

        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">Nenhum resultado encontrado</td></tr>'));
        }
    });
});