var customFileInput = document.getElementById('customFile');
customFileInput.onchange = function(){
    var fullPath = document.getElementById('customFile').value;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        document.getElementById('customFileLabel').innerHTML = filename;
    }
}

function bindPickadate(element){
    let $input = element.pickadate({
        clear: '',
        format: 'dd/mm/yyyy',
        labelMonthNext: 'Go to the next month',
        labelMonthPrev: 'Go to the previous month',
        labelMonthSelect: 'Pick a month from the dropdown',
        labelYearSelect: 'Pick a year from the dropdown',
        selectMonths: true,
        selectYears: true
    });
    let picker = $input.pickadate('picker');
    let triggerElement = '#'+element.attr("id").substring(0, element.attr("id").indexOf("Input"))+'Div';
    $(triggerElement).on('click', function(event) {
        event.stopPropagation();
        picker.open();
    });
}
bindPickadate($('#dateInput'));
