function init(data)
{
    console.log(data);
}


var items_datatable = false;

$().ready(function(){
    
    request('book/get_articles_index', {}, function(result){
        
            items_datatable = $('.items_datatable').DataTable( {
                data: result.items,
                dom: 
                        "<'row'<'col-6 col-sm-12'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'col-12'p>",
                        //"<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'p>>",
                language: arr_ext(dataTables_language, {
                   // search: ''
                }),
                columns: [
                    {data: 'number'},
                    {data: 'name'},
                    {data: 'price'},
                    {data: 'total_count'},
                    {data: 'storage_count'},
                    {data: 'department_count'}
                ],
                rowCallback: function( row, data ) {
                    if (data.item_id)
                    {
                        $(row).attr('item-id', data.item_id);
                    }
                    else
                    {
                        $(row).attr('article-id', data.article_id);
                    }
                }
            });
    });
    
    $(document).on("click", '.items_datatable tr[item-id]', function() {
        
          var item_id = $(this).attr("item-id");
          window.location.href = '/book/view/?item_id=' + item_id;
          
//        var article_id = $(this).attr("article-id");
//        
//        var r1 = request('data/get_article', {id: article_id}, function(result){
//            $('.checked-title').html(result.data.name);
//        });
//                
//        request('book/filter_articles', {article_id: article_id}, function(result){
//            
//            if (result.single_item)
//            {
//                window.location.href = '/book/view/?item_id=' + result.book_item_id;
//                return;
//            }
//
//            r1.done(function(){
//                
//                $('.checked-item').css({display: ''});
//                
//                items_datatable.clear();
//                items_datatable.rows.add(result.items);
//                items_datatable.draw();
//            });
//            
//            
//        });

    });
    
    $(document).on("click", '.items_datatable tr[book-item-id]', function() {
        var id = $(this).attr("book-item-id");
        window.location.href = '/book/view/?item_id=' + id;
    });
    
});


