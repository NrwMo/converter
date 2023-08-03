$('.currency-value').on('input', function(element) {
    $.ajax({
        url: 'get-new-values',
        type: 'POST',
        data: {
            changedCurrency: element.target.id,
            newValueOfCurrency: element.target.value === '' ? 0 : element.target.value
        },
        success: function(result) {
            $.each(result.data, function(index, element) {
                const name = '#'+element.name
                $(name)[0].value = element.newValue
            })
        }
    })
})