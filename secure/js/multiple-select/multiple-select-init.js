
$('.selectCat').multipleSelect({
    isOpen: true,
    keepOpen: true,
	filter: true,
	placeholder: "Select one & more Category",
   
});



///// color //////

$('.selectColor').multipleSelect({
    isOpen: true,
    keepOpen: true,
	filter: true,
	placeholder: "Select one & more Color"
});



///// size //////

$('.selectSize').multipleSelect({
    isOpen: true,
    keepOpen: true,
	filter: true,
	placeholder: "Select one & more Size"
});

// $("#addSize").click(function() {
    // var $select = $(".size select"),
        // $input = $("#sizeInput"),
        // $selected = $("#sizeSelected"),
        // $disabled = $("#sizeDisabled"),
        // value = $.trim($input.val()),
        // $opt = $("<option />", {
            // value: value,
            // text: value
        // });
    // if (!value) {
        // $input.focus();
        // return;
    // }
    // if ($selected.is(":checked")){
        // $opt.prop("selected", true);
    // }
    // if($disabled.is(":checked")){
        // $opt.attr("disabled", true);
    // }
    // $input.val("");
    // $select.append($opt).multipleSelect("refresh");
// });