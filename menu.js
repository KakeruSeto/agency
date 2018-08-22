window.onload = function () {

  var h2_1 = document.getElementById('m1headline');
  var para1 = document.getElementById('m1content');

  var h2_2 = document.getElementById('m2headline');
  var para2 = document.getElementById('m2content');

  var h2_3 = document.getElementById('m3headline');
  var para3 = document.getElementById('m3content');

  var h2_4 = document.getElementById('m4headline');
  var para4 = document.getElementById('m4content');

  var h2_5 = document.getElementById('m5headline');
  var para5 = document.getElementById('m5content');
　
  para1.style.display = "none";
  para2.style.display = "none";
  para3.style.display = "none";
  para4.style.display = "none";
  para5.style.display = "none";

  h2_1.onclick = function () {
    if (para1.style.display == "none") { //非表示だったら
      para1.style.display = "block"; //非表示→表示に切り替え
    } else { //表示だったら
      para1.style.display = "none";

    }
  }

  h2_2.onclick = function () {
    if (para2.style.display == "none") { //非表示だったら
      para2.style.display = "block"; //非表示→表示に切り替え
    } else { //表示だったら
      para2.style.display = "none"; //表示→非表示に切り替え
    }
  }

  h2_3.onclick = function () {
    if (para3.style.display == "none") { //非表示だったら
      para3.style.display = "block"; //非表示→表示に切り替え
    } else { //表示だったら
      para3.style.display = "none";
    }
  }

  h2_4.onclick = function () {
    if (para4.style.display == "none") { //非表示だったら
      para4.style.display = "block"; //非表示→表示に切り替え
    } else { //表示だったら
      para4.style.display = "none";
    }
  }

  h2_5.onclick = function () {
    if (para5.style.display == "none") { //非表示だったら
      para5.style.display = "block"; //非表示→表示に切り替え
    } else { //表示だったら
      para5.style.display = "none";
    }
  }

}
