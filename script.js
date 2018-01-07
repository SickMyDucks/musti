window.onload = function() {
    logs = document.querySelector('.logs');
    if (logs.innerHTML == 'Sorry, file already exists.' || logs.innerHTML == "Invalid username or password") {
        logs.style.color = 'red';
        cleanLogs(2000);
    } else {
        logs.style.color = 'green';
        cleanLogs(2000);
    }
    edit = document.querySelectorAll('td:nth-child(5)');
    for (var i in edit) {
        edit[i].onclick = function() {
            buttonValue = this.attributes[0].value;
            this.parentElement.children[1].children[0].setAttribute('contenteditable', 'true');
            this.parentElement.children[1].children[0].setAttribute('name', buttonValue);
            validate = document.createElement('span');
            validate.innerHTML = '<button type="submit" name="' + buttonValue + '" form="files"><i class="fa fa-check" aria-hidden="true"></i></button>';
            cancel = document.createElement('span');
            cancel.innerHTML = '<button><i class="fa fa-times" aria-hidden="true"></i></button>';
            this.parentElement.children[1].appendChild(document.createElement('div'));
            this.parentElement.children[1].querySelector('div').appendChild(validate);
            this.parentElement.children[1].querySelector('div').appendChild(cancel);
            this.parentElement.children[1].children[0].focus();
            validate.onclick = function() {
                //debugger;
                this.children[0].value = this.parentElement.parentElement.innerText;
                data = this.children[0].value;
            };
            
            this.parentElement.children[1].children[0].onblur = function(e) {
                setTimeout(function() {
                    //debugger;
                    e.target.removeAttribute('contenteditable');
                    e.target.parentElement.removeChild(e.target.parentElement.children[1]);
                }, 100);
                
            };
        };
    }
};

function cleanLogs(time) {
    setTimeout(function() {logs.innerHTML = '';}, time);
}