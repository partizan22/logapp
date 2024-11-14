var data = [];
var items = [];

function init(data)
{
    
}

function draw()
{
        
    var header = '<tr>';
    for (var i in lang.headers)
    {
        header += '<th rowspan="'+ 4  +'" class="v-header h-'+ i +'">' + lang.headers[i] + '</th>';
    }
    
    for (var i of items)
    {
        header += '<th colspan="'+ 3 +'">' + i.name  + '</th>';
    }
    
    header += '</tr>';
    
    header += '<tr>';
    for (var i of items)
    {
        header += '<th colspan="'+ 3 +'">' + i.number  + '</th>';
    }
    header += '</tr>';
    
    header += '<tr>';
    for (var i of items)
    {
        header += '<th colspan="'+ 3 +'">' + i.price  + lang.currency + ' / ' + i.unit  +  '</th>';
    }
    header += '</tr>';
    
    header += '<tr>';
    for (var i of items)
    {
        header += '<th colspan="'+ 1 +'">' + lang.in +  '</th>';
        header += '<th colspan="'+ 1 +'">' + lang.out +  '</th>';
        header += '<th colspan="'+ 1 +'">' + lang.total +  '</th>';
    }
    header += '</tr>';
    
    $('.table-data thead').html(header);
    
    var body = '';
    for (var row of data)
    {
        body += '<tr>';
        for (var k of ['reg_date', 'name', 'number'/*, 'subject_name'*/])
        {
            if (!v)
            {
                v = '';
            }
            var v = row.document[k];
            if (k === 'name')
            {
                v = book_document_names[row.document['type']];
            }
            if (k === 'reg_date')
            {
                v = date_render( v );
            }
            if (k === 'number')
            {
                v = lang['#'] + v + ' ' + lang.date_from + ' ' + date_render( row.document['date'] );
            }
            
            body += '<td>'+ v +'</td>';
        }
        
        for (var i of items)
        {
            for (var k of ['in', 'out', 'res'])
            {
                body += '<td>'+ round_text(row.items[i.id][k]) +'</td>';
            }
        }
        
        body += '</tr>';
    }
    
    $('.table-data tbody').html(body);
}

$().ready(function(){
    
    request('book/get_form13_data', {department_id: department_id}, function(result){
        
        items = result.items;
        data = result.data;
        draw();
         
    });
    
    
});


