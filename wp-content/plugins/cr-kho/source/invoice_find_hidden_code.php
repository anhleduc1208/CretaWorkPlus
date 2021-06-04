<div class='w3-container' style="color:black">
    
    <div class='w3-panel'>
        <h2 class='w3-center'>Tra cứu code hóa đơn cho khách</h2>
    </div> 
    <div class='w3-panel'>
        <table class='w3-table w3-border w3-card w3-striped'>
            <tr>
                <td>Nhập mã hóa đơn</td>
                <td>
                    <input type="text" onkeyup = "findHiddenCode(this.value)">
                </td>
            </tr>
            <tr>
                <td>Code hóa đơn cho khách</td>
                <td>
                    <h4 id="hiddenCode"></h4>
                </td>
            </tr>
            <tr>
                <td>Link gửi khách</td>
                <td>
                    <h4 id="hiddenCodeLink"></h4>
                </td>
            </tr>


        </table>
    </div>
</div>

<script>
    function findHiddenCode(code) {
        if (code.length == 0) {
            document.getElementById("hiddenCode").innerHTML = "";
        } else {
            var xhttp = new XMLHttpRequest();
            var url = "http://creta.work/wp-json/wp/v2/invoices?_fields=hiddenCode,code&meta_key=code&meta_value=" + code;
            var data = "";
            var dataObj;
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = this.responseText;
                    dataObj = JSON.parse(data);
                    if (dataObj[0]) {
                        handle(dataObj[0]);
                    } else {
                        document.getElementById("hiddenCode").innerHTML = "Không có hóa đơn lày";
                    }
                    //handle(dataObj[0]);
                    //document.getElementById("hiddenCode").innerHTML = dataObj[0]['hiddenCode'];
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
           
        }
    }
    
    function handle(obj) {
        var txt;
        var url;
        if (obj['hiddenCode']) {
            txt = obj['hiddenCode'];           
        } else {
            txt = obj['code'];   
        }
        url = "http://creta.work/thong-tin-don-hang/?code=" + txt;
        str="<a>"+url+"</a>";
        str+="<a class='w3-right' href='"+url+"'><button class='w3-button w3-black w3-round-xlarge'>Đi đến</button></a>";
        document.getElementById("hiddenCode").innerHTML = txt;
        document.getElementById("hiddenCodeLink").innerHTML = str;
    }
</script>
