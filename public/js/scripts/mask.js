var MaskFormTools = function () {
   
    return {
        //main function to initiate the module
        init: function () {
        	$.extend($.inputmask.defaults, {
                'autounmask': true
            });
        	
        	$(".mask_hour").inputmask("mask", {
        	    "mask": "99:99"
        	});
        	
        	$(".mask_cpf").inputmask("mask", {
        	    "mask": "999.999.999-99"
        	});
        	
        	$(".mask_cnpj").inputmask("mask", {
        	    "mask": "99.999.999/9999-99"
        	});
                
            $(".mask_date").inputmask("d/m/y", {
                "placeholder": "dd/mm/yyyy"
            }); //multi-char placeholder
            $(".mask_phone").inputmask("mask", {
                "mask": "(99)9999-99999"
            }); //specifying fn & options
            $(".mask_number").inputmask({
                "mask": "9",
                "repeat": 10,
                "greedy": false
            }); // ~ mask "9" or mask "99" or ... mask "9999999999"
            $(".mask_decimal").inputmask('decimal', {
                rightAlignNumerics: false
            }); //disables the right alignment of the decimal input
            $(".mask_currency").inputmask('R$ 999.999.999,99', {
                numericInput: true
            }); //123456  =>  € ___.__1.234,56
            $(".mask_cep").inputmask("mask", {
        	    "mask": "99999-999"
        	}); //specifying fn & options
        }
    };

}();