function loadTxt()
    {
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "PayPal Email Address";
	txtLang[1].innerHTML = "Item Cost:";
	txtLang[2].innerHTML = "Currency:";
	txtLang[3].innerHTML = "Item Number:";
	txtLang[4].innerHTML = "Shipping:";
	txtLang[5].innerHTML = "Tax Rate:";
	txtLang[6].innerHTML = "Item Description:";
    document.getElementById("btnApply").value = "apply";
    document.getElementById("btnOk").value = " ok ";
    }
function writeTitle()
    {
    document.write("<title>Add PayPal Buy Now Button</title>")
    }