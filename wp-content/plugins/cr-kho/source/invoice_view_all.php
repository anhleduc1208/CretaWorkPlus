<div class="" style="color:black">
    <h3 class="w3-center">Danh sách tất cả hóa đơn của CRETA</h3>

    </br>
   

    <div id="choose_what_to_query" class="w3-display-container">
        <form class="w3-display-middle">
            <select id="myChoice" onchange="invoiceChoose()">
                <option value="1" selected>Tất cả</option>
                <option value="CHO_LEN_KE_HOACH">Chờ lên kế hoạch</option>
                <option value="DANG_DONG_HANG">Đang đóng hàng</option>  
                <option value="CHO_GIAO_HANG">Chờ giao hàng</option>
                <option value="DA_GIAO_VAN">Đã giao vận</option>
                <option value="HOAN_THANH">Đã hoàn thành</option>     
                <option value="0">Đã hủy</option>          
            </select>
        </form>
    </div>

    </br>

    <div id="invoices_view">
        <table id="table_view" class="w3-table-all w3-bordered w3-striped ">
            <!-- <tr>
                <th>Mã đơn</th>
                <th>Tên khách</th>
                <th>Ngày bán</th>
                <th>Tình trạng</th>
                <th>Hành động</th>
            </tr>           
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> -->
            
        </table>
    </div>    

</div>

<script>
    getInvoices(1);
    //var i = 0;
    setInterval(updateTable,20000);
    
    function updateTable(){
        var choi = document.getElementById("myChoice").value;
        getInvoices(choi);        
    }

    function invoiceChoose(){
        var choice = document.getElementById("myChoice").value;
        getInvoices(choice);
    }
    
    function getInvoices(str){
        var xhttp = new XMLHttpRequest();
        var url = "";
        if (str == 1) {
            url = "http://creta.work/wp-json/wp/v2/invoices?_fields=id,code,hiddenCode,customerInfo,purchaseDate,deliveryStatus,statusInv&meta_query[0][key]=statusInv&meta_query[0][value]=official&meta_query[0][compare]==&per_page=40&orderby=title&meta_key=code&order=desc";
        } else if (str==0) {
            url = "http://creta.work/wp-json/wp/v2/invoices?_fields=id,code,hiddenCode,customerInfo,purchaseDate,deliveryStatus,statusInv&meta_query[0][key]=statusInv&meta_query[0][value]=canceled&meta_query[0][compare]==&per_page=40&orderby=title&meta_key=code&order=desc";
        }   else {
            url = "http://creta.work/wp-json/wp/v2/invoices?_fields=id,code,hiddenCode,customerInfo,purchaseDate,deliveryStatus,statusInv&meta_query[0][key]=statusInv&meta_query[0][value]=official&meta_query[0][compare]==&orderby=title&meta_key=code&order=desc&per_page=40&meta_key=deliveryStatus&meta_value=" + str;
        }        
        var data ="";
        var dataOBJ;
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = this.responseText;
                dataOBJ = JSON.parse(data);
                drawTable(dataOBJ);
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
        
    }
    function drawTable(obj) {
        var tbl_element = document.getElementById("table_view");        
        var txt="";
        var cnt = obj.length;
        var i=0;
        txt += "<tr class='w3-khaki '>";
        txt += "<th class='w3-center'>Mã đơn</th>";
        txt += "<th class='w3-center'>Tên khách</th>";
        txt += "<th class='w3-center'>Ngày bán</th>";
        txt += "<th class='w3-center'>Tình trạng</th>";
        txt += "<th class='w3-center'>Chi tiết</th>";
        txt += "<th class='w3-center'>Hành động</th>";
        txt += "</tr>"; 

        for (i=0; i<cnt;i++){
            var single_inv = obj[i];
            var invStatus = single_inv.statusInv;
            if (invStatus=='official') {
                var invCode = single_inv.code;
                var invHiddenCode = single_inv.hiddenCode;
                var deliStatus = single_inv.deliveryStatus;
                var customerInfo = single_inv.customerInfo[0];
                var cusName = customerInfo.customerName;
                var cusAddress = customerInfo.customerAddress;
                var purDate0 = single_inv.purchaseDate;
                var purDate = purDate0.replace("T"," ");
                var planURL = "http://creta.work/invoice-single-plan/?code=" + invCode;
                var toDoURL = "";
                var detailURL = "http://creta.work/invoice-single-detail/?code=" + invCode;
                var toCusURL="";
                if (invHiddenCode=='') {
                    toCusURL = "http://creta.work/thong-tin-don-hang/?code=" + invCode;
                } else {
                    toCusURL = "http://creta.work/thong-tin-don-hang/?code=" + invHiddenCode;
                }
                
                var num = 0;
                var color = "red";
                var state ="";
                var btnName ="";

                switch(deliStatus) {
                case "CHO_LEN_KE_HOACH": 
                    num =  0;
                    color = "red";
                    state = "Chờ lên kế hoạch";
                    toDoURL = "http://creta.work/invoice-0-plan/?code=" + invCode;
                    btnName = "Plan";
                    break;
                case "DANG_DONG_HANG": 
                    num =  1;
                    color = "yellow";
                    state = "Đang đóng hàng";
                    toDoURL = "http://creta.work/invoice-1-package/?code=" + invCode;
                    btnName ="Đóng";
                    break;
                case "CHO_GIAO_HANG": 
                    num =  2;
                    color = "teal";
                    state = "Chờ giao hàng";
                    toDoURL = "http://creta.work/invoice-2-delivery/?code=" + invCode;
                    btnName ="Giao";
                    break;
                case "DA_GIAO_VAN": 
                    num =  3;
                    color = "purple";
                    state = "Đã giao vận";
                    toDoURL = "http://creta.work/invoice-3-confirm/?code=" + invCode;
                    btnName ="Check";
                    break;
                case "HOAN_THANH": 
                    num =  4;
                    color = "green";
                    state = "Hoàn thành";
                    toDoURL = "http://creta.work/invoice-4-developing/?code=" + invCode;
                    btnName ="Done";
                    break;   
                default:  
                }

                txt += "<tr>";
                txt += "<td>" + invCode + "</td>";
                txt += "<td>" + cusName + "</td>"; 
                txt += "<td>" + purDate + "</td>";
                txt += "<td class='w3-" + color + "'>[" + num + "] - " + state + "</td>";
                txt += "<td class='w3-center'>";
                txt += "<a  href='" + detailURL + "'><button class='w3-button w3-khaki w3-round '>Detail</button></a>";
                
                   txt += "&nbsp;|&nbsp;";
                    txt += "<a  href='" + planURL + "'><button class='w3-button w3-khaki w3-round '>Plan GV</button></a>";

                    txt += "&nbsp;|&nbsp;";
                    txt += "<a  href='" + toCusURL + "'><button class='w3-button w3-khaki w3-round '>Trang KH</button></a>";
                
                txt += "</td>";
                txt += "<td class='w3-center'>";
                txt += "<a  href='" + toDoURL + "'><button class='w3-button w3-"+color+" w3-round '>"+btnName+ "</button></a>";
                txt += "</td>";
                txt += "</tr>";

            } else if (invStatus=='canceled') {
                var invCode = single_inv.code;
                var invHiddenCode = single_inv.hiddenCode;
                var deliStatus = single_inv.deliveryStatus;
                var customerInfo = single_inv.customerInfo[0];
                var cusName = customerInfo.customerName;
                var cusAddress = customerInfo.customerAddress;
                var purDate0 = single_inv.purchaseDate;
                var purDate = purDate0.replace("T"," ");
                var planURL = "http://creta.work/invoice-single-plan/?code=" + invCode;
                var toDoURL = "";
                var detailURL = "http://creta.work/invoice-single-detail/?code=" + invCode;
                var toCusURL="";
                if (invHiddenCode=='') {
                    toCusURL = "http://creta.work/thong-tin-don-hang/?code=" + invCode;
                } else {
                    toCusURL = "http://creta.work/thong-tin-don-hang/?code=" + invHiddenCode;
                }
                
                var num = 'x';
                var color = "gray";
                var state ="Đã hủy";
                var btnName ="";

                

                txt += "<tr>";
                txt += "<td>" + invCode + "</td>";
                txt += "<td>" + cusName + "</td>"; 
                txt += "<td>" + purDate + "</td>";
                txt += "<td class='w3-" + color + "'>[" + num + "] - " + state + "</td>";
                txt += "<td class='w3-center'>";
                txt += "<a  href='" + detailURL + "'><button class='w3-button w3-khaki w3-round '>Chi tiết đơn</button></a>";
                
                   
                
                txt += "</td>";
                txt += "<td class='w3-center'>";
                
                txt += "</td>";
                txt += "</tr>";
            }
                
        }

        


        tbl_element.innerHTML = txt;
    }

</script>