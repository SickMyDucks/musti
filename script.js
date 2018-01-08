window.onload = function() {
    logs = document.querySelector('.logs');
    if (logs.innerHTML == 'Sorry, file already exists.' || logs.innerHTML == "Invalid username or password") {
        logs.style.color = 'red';
        cleanLogs(2000);
    } else {
        logs.style.color = 'green';
        cleanLogs(2000);
    }

    download = document.querySelectorAll('.download');
    edit = document.querySelectorAll('td:nth-child(5)');
    remove = document.querySelectorAll('.delete');

    for (var i in download) {
        download[i].onclick = function() {
            this.name = this.children[0].attributes[2].value;
        };
    }
    

    for (var i in edit) {
        edit[i].onclick = function() {
            buttonValue = this.children[1].attributes[2].value;
            this.parentElement.children[1].children[0].setAttribute('contenteditable', 'true');
            validate = document.createElement('span');
            validate.innerHTML = '<button type="submit" name="' + buttonValue + '" form="files"><i class="fa fa-check" aria-hidden="true" name=></i></button>';
            cancel = document.createElement('span');
            cancel.innerHTML = '<button><i class="fa fa-times" aria-hidden="true"></i></button>';
            this.parentElement.children[1].appendChild(document.createElement('div'));
            this.parentElement.children[1].querySelector('div').appendChild(validate);
            this.parentElement.children[1].querySelector('div').appendChild(cancel);
            this.parentElement.children[1].children[0].focus();
            validate.onclick = function() {
                this.children[0].value = this.parentElement.parentElement.innerText;
            };
            
            this.parentElement.children[1].children[0].onblur = function(e) {
                setTimeout(function() {
                    e.target.removeAttribute('contenteditable');
                    e.target.parentElement.removeChild(e.target.parentElement.children[1]);
                }, 100);
                
            };
        };
    }

    for (var i in remove) {
        remove[i].onclick = function() {
            this.name = this.children[0].attributes[2].value;
        };
    }
};

function cleanLogs(time) {
    setTimeout(function() {logs.innerHTML = '';}, time);
}