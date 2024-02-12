function init(data)
{
    console.log(data);
}


var items_datatable = false;

$().ready(function(){
    
    request('document/get_documents', {'id' : document_ids}, function(result){
        
        var tpl = $('.print-container').html();
        $('.print-container').html('');
        
        for (var doc of result.documents)
        {
            for (var i=0; i<3; i++)
            {
                var div = $('<div>');
                div.html(tpl);

                fill_document(div, doc);

                $('.print-container').append(div);                
            }
        }            
    });
});


function fill_document(container, result)
{
    fill_vars({
        doc_number: result.document.number,
        doc_date: result.document.date,
        subject_name: result.subject.name,
        total_items: result.total_items
    }, true, container);
    
    var n = 0;
    for (var i of result.items){
        container.find('.print-items-table-total').before('<tr>'  
                + '<td>'+ (++n) +'.</td>'
                + '<td class="l">'+ (i.name) +'</td>'
                + '<td class="bl">'+ (i.number) +'</td>'
                + '<td>'+ (i.unit) +'</td>'
                + '<td>'+ display_category(i.category) +'</td>'
                + '<td>'+ (round_text(i.count)) +'</td>'
                + '<td class="br">'+ (round_text(i.count)) +'</td>'
                + '<td>Ціна '+ (i.price) +' грн</td>'
            + '</tr>'
        );
    }

}
