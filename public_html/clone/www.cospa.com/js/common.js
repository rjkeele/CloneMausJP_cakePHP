

function opencart()

{

    win = window.open( url_site + "/index.php/cart_list/__siteid/" + siteid + "/__sid/"+sid,"cart","width=650,height=600,scrollbars=yes,resizable=yes");

    win.focus();

}





function opencart2()

{

    document.OpenCartForm.submit();

}



function openMember()

{

    win = window.open( url_site+"/index.php/member_index/__siteid/" + siteid + "/__sid/"+sid,"cart","width=650,height=600,scrollbars=yes,resizable=yes");

    win.focus();

}



function openMember2()

{
    document.OpenMemberForm.submit();

}



function openwin(url)

{

    window.open( url , "subwin", "width=500,height=310");

}

function openmap(url)

{

    window.open( url , "mapwin", "width=650,height=650,left=0,top=0,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,favorites=no,resizable=yes");

}



function on(obj)

{

    

    obj.src= url + "/img/geestore/base/"+obj.id+"b.gif";

    

}



function out(obj)

{

    

    obj.src= url + "/img/geestore/base/"+obj.id+"a.gif";

    

}