function erregistroaBaieztatu(){
    if(document.getElementById('izab').value==='' || !isNaN(document.getElementById('izab').value)){
        alert("Izena hutsik dago edo zenbaki bat du.");
        return false;
    }
    var nan = document.getElementById('NAN').value;
    var expresio_erregularra = /^\d{8}[a-zA-Z]$/;
    if(expresio_erregularra.test(nan)==false){
        alert("NANaren formatua ez da zuzena.");
        return false;
    }
    var zenb = nan.substr(0,nan.length-1);
    var letr = nan.substr(nan.length-1,1);
    zenb = zenb % 23;
    var balio = 'TRWAGMYFPDXBNJZSQVHLCKET';
    balio=balio.substring(zenb,zenb+1);
    if (balio!=letr.toUpperCase()) {
        alert("NAN-aren letra ez da zuzena.");
        return false;
    }

    if(!/^[0-9]{9}$/.test(document.getElementById('tlf').value)){
        alert("Telefono zenbakia ez da zuzena.");
        return false;
    }

    if(!/^\d{4}-\d{2}-\d{2}$/.test(document.getElementById('jd').value)){
        alert("Dataren formatua ez da zuzena.");
        return false;
    }

 
    if(!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(document.getElementById('mail').value)){
        alert("E-maila ez da zuzena.");
        return false;
    }
}