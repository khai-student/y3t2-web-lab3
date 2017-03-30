$( document ).ready(WindowOnReady);

function jsSubmit() {
    document.forms.namedItem("regform").elements["regAction"].value = "true";
    document.regform.submit();
}

function WindowOnReady() {
    $("#reg-button").on("click", function(e){
        $("#regform").submit();
        
        e.preventPropagation();
    });
}