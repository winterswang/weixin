/**
 * localStorage
 */
function collectHouse() {
    if(('localStorage' in window) && window['localStorage'] !== null) {
        var house_info = document.getElementById("house_info").value;
        if (!localStorage.getItem("pageLoadCount")) localStorage.setItem("pageLoadCount",0);
        localStorage.pageLoadCount = parseInt(localStorage.getItem("pageLoadCount")) + 1;  //格式转换
        var cnt = localStorage.pageLoadCount;
        var cnt1 = cnt.toString();
        localStorage.setItem(cnt1,house_info);
        if(localStorage.getItem(cnt1)) {
            var collect = document.getElementById("cohouse");
            var aa = "已收藏";
            collect.innerHTML = aa;
            collect.style.backgroundColor = "#979797";
            collect.style.disabled = true;
            collect.onclick = null;
        }
    } else {
        alert("Your browser does not support HTML5 localStorage. Try upgrading.");
    }
}

/**
 * 自动加载判断是否已收藏
 */
window.onload = function() {
    var tbl = document.getElementById("tb1")
    tbl.querySelector("tr:last-child").style.borderBottom = "none";
    var collect = document.getElementById("cohouse");
    var aa = "已收藏";
    var bb = "收藏房源";
    var houseArr = [];
    for(var key in localStorage) {houseArr.push(localStorage[key])}
    console.log(houseArr);
    if(houseArr.indexOf(document.getElementById("house_info").value) >= 0) {
        collect.innerHTML = aa;
        collect.style.backgroundColor = "#979797";
        collect.style.disabled = true;
        collect.onclick = null;
    } else {
        collect.innerHTML = bb;
        collect.style.backgroundColor = "#f4775a";
        collect.style.disabled = false;
    }
}

/**
 * 侦听storage事件
 */
if(window.addEvementListener) {    //FF chrome
    window.addEvementListener("storage",handle_storage,false);
} else if(window.attachEvement) {   //IE
    window.attachEvement("onstorage",handle_storage);
}

function handle_storage(e) {
    if(!e) {e = e || window.storageEvent;}
    showObject(e);
}

function showObject(obj) {
    if(!obj) {return;}
    for(var i in obj) {
        if(typeof(obj[i]) != "object" || obj[i] == null) {
            console.log(i + ":" + obj[i] + "\n");
        } else {
            console.log(i + ":object" + "\n");
        }
    }
}
