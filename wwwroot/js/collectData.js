(function(){
    window.localData = {
        isLocalStorage:!!window.localStorage ? true:false,

        //初始化房源收藏
        initHouse:function() {
            if(this.isLocalStorage) {
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
        },
        
        //初始化店铺收藏
        initStore:function() {
            if(this.isLocalStorage) {
                var collect = document.getElementById("costore");
                var storeArr = [];
                for(var key in localStorage) {storeArr.push(localStorage[key])}
                console.log(storeArr);
                if(storeArr.indexOf(document.getElementById("store_info").value) >= 0) {
                    collect.src = "/img/district/collected.png";
                    collect.style.disabled = true;
                    collect.onclick = null;
                } else {
                    collect.src = "/img/district/collectStore.png";
                    collect.style.disabled = false;
                }
            }
        },
        
        //收藏房源
        collectHouse:function() {
            if(this.isLocalStorage) {
                var house_info = document.getElementById("house_info").value;
                if (!localStorage.getItem("pageLoadCount")) localStorage.setItem("pageLoadCount",0);
                localStorage.pageLoadCount = parseInt(localStorage.getItem("pageLoadCount")) + 1;  //格式转换
                var cnt1 = localStorage.pageLoadCount.toString();
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
        },
        
        //收藏店铺
        collectStore:function() {
            if(this.isLocalStorage) {
                var store_info = document.getElementById("store_info").value;
                if (!localStorage.getItem("pageLoadCount")) localStorage.setItem("pageLoadCount",0);
                localStorage.pageLoadCount = parseInt(localStorage.getItem("pageLoadCount")) + 1;  //格式转换
                //var cnt = localStorage.pageLoadCount_1;
                var cnt2 = localStorage.pageLoadCount.toString();
                localStorage.setItem(cnt2,store_info);
                if(localStorage.getItem(cnt2)) {
                    var collect = document.getElementById("costore");
                    collect.src = "/img/district/collected.png";
                    collect.style.disabled = true;
                    collect.onclick = null;
                }
            } else {
                alert("Your browser does not support HTML5 localStorage. Try upgrading.");
            }
        },
        
        //取消收藏
        removeCollect:function() {return false;}
    }

    var cohouse = document.getElementById("cohouse");
    var costore = document.getElementById("costore");
    if(cohouse) {
        cohouse.onclick = function() {localData.collectHouse();}
    } else if(costore) {
        costore.onclick = function() {localData.collectStore();}
    }  
})()


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