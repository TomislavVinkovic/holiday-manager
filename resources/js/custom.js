window.disableOnMembers = function (e, max) {
    let id = e.target.value;
    document.getElementById(id).setAttribute('disabled', 'disabled');

    for(let i = 0; i<=max; i++) {
        if(document.getElementById(i.toString()) !== null && i.toString() !== id && document.getElementById(i.toString()).getAttribute('disabled') === 'disabled') {
            document.getElementById(i.toString()).toggleAttribute('disabled');
        }
    }
}