function request(action, data, success)
{
    var s = action.split("/");
    return $.ajax('/ajax.php?c='+ s[0] +'&action=' + s[1], {
        type: 'POST',
        data: data,
        dataType: 'json',
        success: success
    });
}

function arr_ext(arr1, arr2)
{
    var result = {};
    for (var k in arr1)
    {
        if (typeof arr1[k] === 'object')
        {
            result[k] = arr_ext(arr1[k], arr2[k] ? arr2[k] : {});
        }
        else
        {
            result[k] = arr1[k];
        }
    }
    
    for (var k in arr2)
    {
        if (typeof arr2[k] === 'object')
        {
            if (typeof arr1[k] !== 'object')
            {
                result[k] = arr2[k];
            }
        }
        else
        {
            result[k] = arr2[k];
        }
    }
    
    return result;
}

function round_text(x)
{
    x = parseFloat(x);
    if (isNaN(x))
    {
        return '';
    }
    return x.toFixed(2);
}

function round(x)
{
    return parseFloat(round_text(x));
}

function fill_vars(obj, clear, container)
{
    console.log(obj);
    if (! container)
    {
        container = $(document);
    }
    
    container.find('[data-var]').each(function(i, e){
        
        var k = $(e).attr('data-var');
        
        if (typeof obj[k] === 'undefined')
        {
            if (! clear)
            {
                return;
            }
            
            var v = '';
        }
        else
        {
            var v = obj[k];
        }
        
        if ((e.tagName == 'INPUT') || (e.tagName == 'SELECT'))
        {
            $(e).val(v);
        }
        else
        {
            $(e).html(v);
        }
    });
}

function display_category(cat){
    if (!cat)
    {
        return '';
    }
    
    var cats = ['I', 'II', 'III', 'IV', 'V'];
    return cats[ cat-1 ];
}

function set_page_title(title)
{
    $('.page-title').html(title);
    document.title = title;
}

function date_render(date, type){
        
    if (!type)
    {
        type = 'display';
    }
    
    switch (type)
    {
        case 'display':
            
            const d = new Date(date);
            return  (d.getDate()+"").padStart(2, '0') + '.' +  ((d.getMonth()+1)+"").padStart(2, '0') + '.' + d.getFullYear();
            


        default:
            
            return date;

    }
}

function count_render(data, type, row){
    
    switch (type)
    {
        case 'display':
            return  round_text(data);
            
        default:
            return data;
    }
    
}

function category_render(data, type, row){
        
    switch (type)
    {
        case 'display':
            var cats = ['I', 'II', 'III', 'IV', 'V'];
            return  data > '' ? cats[data-1] : '-';
            
        default:
            return data;
    }
    
}