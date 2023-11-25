function erregistroaBaieztatu() {
    //izena huts dagoen edo zenbakirik duen begiratzen da
    if (document.getElementById('izab').value === '' || /\d/.test(document.getElementById('izab').value)) {
        alert("Izena hutsik dago edo zenbaki bat du.");
        return false;
    }
    //NAN-aren formato begiratzen da (oraindik ez da begiratzen ea letra zenbakiarekin bat datorren)
    var nan = document.getElementById('NAN').value;
    var expresio_erregularra = /^\d{8}[a-zA-Z]$/;
    if (expresio_erregularra.test(nan) == false) {
        alert("NANaren formatua ez da zuzena.");
        return false;
    }
    //NAN-aren zenbakiaren eta letraren arteko erlazioa zuzena den begiratzen da https://donnierock.com/2011/11/05/validar-un-dni-con-javascript/
    var zenb = nan.substr(0, nan.length - 1);
    var letr = nan.substr(nan.length - 1, 1);
    zenb = zenb % 23;
    var balio = 'TRWAGMYFPDXBNJZSQVHLCKET';
    balio = balio.substring(zenb, zenb + 1);
    if (balio != letr.toUpperCase()) {
        alert("NAN-aren letra ez da zuzena.");
        return false;
    }

    //begiratzen da telefonoan karaktere guztiak zenbakiak direla eta 9 daudela
    if (!/^[0-9]{9}$/.test(document.getElementById('tlf').value)) {
        alert("Telefono zenbakia ez da zuzena.");
        return false;
    }

    if (isNaN(Date.parse(document.getElementById('jd').value))) {
        alert("Dataren formatua ez da zuzena.");
        return false;
    }

    //mail-aren formatua zuzena dela frogatzen da
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(document.getElementById('mail').value)) {
        alert("E-maila ez da zuzena.");
        return false;
    }

    if (!/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(document.getElementById('pass').value)) {
        alert("Pasahitza 8 karaktere, letra larri bat, letra xehe bat, zenbaki bat, eta karaktere ez alfanumeriko bat gutxienez izan behar ditu.");
        return false;
    }


}

function datuakAldatuBaieztatu() {
    //izena huts dagoen edo zenbakirik duen begiratzen da
    if (document.getElementById('izab').value === '' || /\d/.test(document.getElementById('izab').value)) {
        alert("Izena hutsik dago edo zenbaki bat du.");
        return false;
    }
    //NAN-aren formato begiratzen da (oraindik ez da begiratzen ea letra zenbakiarekin bat datorren)
    var nan = document.getElementById('NAN').value;
    var expresio_erregularra = /^\d{8}[a-zA-Z]$/;
    if (expresio_erregularra.test(nan) == false) {
        alert("NANaren formatua ez da zuzena.");
        return false;
    }
    //NAN-aren zenbakiaren eta letraren arteko erlazioa zuzena den begiratzen da https://donnierock.com/2011/11/05/validar-un-dni-con-javascript/
    var zenb = nan.substr(0, nan.length - 1);
    var letr = nan.substr(nan.length - 1, 1);
    zenb = zenb % 23;
    var balio = 'TRWAGMYFPDXBNJZSQVHLCKET';
    balio = balio.substring(zenb, zenb + 1);
    if (balio != letr.toUpperCase()) {
        alert("NAN-aren letra ez da zuzena.");
        return false;
    }

    //begiratzen da telefonoan karaktere guztiak zenbakiak direla eta 9 daudela
    if (!/^[0-9]{9}$/.test(document.getElementById('tlf').value)) {
        alert("Telefono zenbakia ez da zuzena.");
        return false;
    }

    if (isNaN(Date.parse(document.getElementById('jd').value))) {
        alert("Dataren formatua ez da zuzena.");
        return false;
    }

    //mail-aren formatua zuzena dela frogatzen da
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(document.getElementById('mail').value)) {
        alert("E-maila ez da zuzena.");
        return false;
    }

    if (!/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(document.getElementById('pass').value)) {
        if (!document.getElementById('pass').value.trim() == '') {
            alert("Pasahitza 8 karaktere, letra larri bat, letra xehe bat, zenbaki bat, eta karaktere ez alfanumeriko bat gutxienez izan behar ditu.");
            return false;
        }XMLDocument
    }


}

function prezioZenbakia() {
    if (isNaN(document.getElementById('prezio').value)) {
        alert("Prezioan zenbaki bat egon behar da.");
        return false;
    }
}