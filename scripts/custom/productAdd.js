function __ready__(win,doc){
    'use strict';

    var properties = doc.getElementsByClassName('property');

     for(var i = 0,ln = properties.length;i<ln;i++){
        properties[i].addEventListener( 'click', propertyStateChanged);
    }

    var exist_subprops = doc.querySelectorAll('.sub-property.row.hidden');

        for(var i= 0,ln=exist_subprops.length;i<ln;i++){

        if(exist_subprops[i]) {
            if (exist_subprops[i].getElementsByClassName('subproperty-was-set')[0]) {
                var check = null;
                if (check = exist_subprops[i].parentNode.getElementsByTagName('input')[0]) {
                    check.setAttribute('checked', 'checked');
                    check.parentNode.setAttribute('class','checked');
                    exist_subprops[i].classList.remove('hidden');
                }
            }
        }
    }

};

window.onload = function(){
    __ready__(this,window.document);
};

function propertyStateChanged(event){

    var subContainer = this.getElementsByClassName('sub-property')[0];
    var checkbox = this.getElementsByTagName('input')[0];

    if(!subContainer && !checkbox){
        return console.log('sub-property-container-not-found');
    }

    if(checkbox.checked) {
        subContainer.setAttribute('class', 'sub-property row');
    }else{
        subContainer.setAttribute('class', 'sub-property row hidden');
    }

}

function findParentNode(parentName, childObj) {
    var testObj = childObj.parentNode;
    var count = 1;
    while(testObj.getAttribute('class') != parentName) {
        testObj = testObj.parentNode;
        count++;
    } return testObj;
}