document.getElementById("form-modal-1").style.display = 'none';
document.getElementById("formTwo").style.display = 'none';

function formModalOne() {
    document.getElementById("modal").style.display = 'none';
    document.getElementById("form-modal-1").style.display = 'block';
}

function formModalTwo() {
    document.getElementById("modal").style.display = 'none';
    document.getElementById("form-modal-1").style.display = 'block';
    document.getElementById("formTwo").style.display = 'block';
}