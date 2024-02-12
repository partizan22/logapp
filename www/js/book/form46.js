var data = [];
var departments = [];

function init(data)
{
    
}

function draw()
{
    var show_departments = $('.show-departments').prop('checked') ? true : false;
    var show_categories = $('.show-categories').prop('checked') ? true : false;
    var dpc = show_departments ? ( 1 + departments.length ) : 2;
    
    var header = '<tr>';
    for (var i in lang.headers)
    {
        header += '<th rowspan="'+ (show_categories ? 4 : 2) +'" class="v-header h-'+ i +'">' + lang.headers[i] + '</th>';
    }
    header += '<th colspan="'+ (show_categories ? 6 : 1) +'" rowspan="2" class="h-header h-in_book_total" >'+ lang.in_book_total +'</th>';
    header += '<th colspan="'+ (dpc * (show_categories ? 6 : 1)) +'" class="h-header">' + lang.in_departments_h + '</th>';
    header += '</tr><tr>';
    header += '<th class="h-in-starage">' + lang.in_starage  + '</th>';
    if (show_departments)
    {
        for (var d of departments)
        {
            header += '<th colspan="'+ (show_categories ? 6 : 1) +'">' + d.name  + '</th>';
        }
    }
    else
    {
        header += '<th colspan="'+ (show_categories ? 6 : 1) +'" class="h-in-departments">' + lang.in_departments  + '</th>';
    }
    header += '</tr>';
    
    if (show_categories)
    {
        header += '<tr>';
        for (var i=0; i<=dpc; i++)
        {
            header += '<th rowspan="2">' + lang.total + '</th>';
            header += '<th colspan="5">' + lang.by_cats + '</th>';
        }
        header += '</tr>';
        
        header += '<tr>';
        for (var i=0; i<=dpc; i++)
        {
            for (var j=0; j<5; j++)
            {
                header += "<th class='h-cat'>"+ (1+j) +"</th>";
            }
        }
        header += '</tr>';
    }
    
    header += '<tr>';
    c = 0;
    for (var h in lang.headers)
    {
        c ++;
        header += "<th>"+ c +"</th>";
    }
    
    for (i=0; i<=dpc; i++)
    {
        c ++;
        header += "<th>"+ c +"</th>";
        for (var j=0; j<5; j++)
        {
            c ++;
            if (show_categories)
            {
                header += "<th>"+ c +"</th>";
            }
        }
    }
    
    header += '</tr>';
    
    $('.table-data').removeClass('show-categories');
    $('.table-data').removeClass('show-departments');
    
    if (show_categories)
    {
        $('.table-data thead').addClass('show-categories');
    }
    
    if (show_departments)
    {
        $('.table-data thead').addClass('show-departments');
    }
    
    
    $('.table-data thead').html(header);
    
    var body = '';
    for (var row of data)
    {
        body += '<tr>';
        for (var k of ['reg_date', 'name', 'number', 'date', 'subject_name'])
        {
            var v = row.document[k];
            if (k === 'name')
            {
                v = document_names[row.document['type']];
            }
            body += '<td>'+ v +'</td>';
        }
        
        for (var k of ['in', 'out'])
        {
            body += '<td>'+ row[k] +'</td>';
        }
        
        
        body += '<td>'+ row.total[0] +'</td>';
        if (show_categories)
        {
            for (var j=0; j<5; j++)
            {
                body += '<td>'+ row.total[j+1] +'</td>';
            }
        }
        
        body += '<td>'+ row.storage[0] +'</td>';
        if (show_categories)
        {
            for (var j=0; j<5; j++)
            {
                body += '<td>'+ row.storage[j+1] +'</td>';
            }
        }
        
        if (show_departments)
        {
            for (var i in departments)
            {
                var dep_id = departments[i].id;
                body += '<td>'+ row.departments[dep_id][0] +'</td>';
                if (show_categories)
                {
                    for (var j=0; j<5; j++)
                    {
                        body += '<td>'+ row.departments[dep_id][j+1] +'</td>';
                    }
                }
            }
        }
        else
        {
            body += '<td>'+ row.dep_total[0] +'</td>';
            if (show_categories)
            {
                for (var j=0; j<5; j++)
                {
                    body += '<td>'+ row.dep_total[j+1] +'</td>';
                }
            }
        }
        
        body += '</tr>';
    }
    
    $('.table-data tbody').html(body);
}

$().ready(function(){
    
    request('book/get_form46_data', {item_id: item_id}, function(result){
        
        departments = result.departments;
        data = result.data;
        draw();
         
    });
    
    
});


