<!DOCTYPE html>
<html>
<head>
	<title>My Redis Table</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #4CAF50;
			color: white;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
	</style>

</head>
<body>
	<h1>My Redis Table</h1>
    <select id="pair">
        <option value="none">none</option>
        <option value="INCH/USD">INCH/USD</option>
        <option value="VSY/USD">VSY/USD</option>
        <option value="AAVE/USD">AAVE/USD</option>
        <option value="ADA/USD">ADA/USD</option>
        <option value="ALBT/USD">ALBT/USD</option>
        <option value="AXS/USD">AXS/USD</option>
        <option value="ZCN/USD">ZCN/USD</option>
        <option value="BEST/US">BEST/USD</option>
        <option value="ETP/USD">ETP/USD</option>
        <option value="SNX/USD">SNX/USD</option>
        <option value="BDOG/USD">BDOG/USD</option>
        <option value="CLO/USD">CLO/USD</option>
        <option value="YGG/USD">YGG/USD</option>
        <!-- Thêm các tùy chọn khác tương ứng với các cặp tiền khác -->
    </select>

    <button id="submit-btn">Submit</button>
    
    <label>
        <input type="checkbox" id="sort-checkbox"> Sắp xếp theo giá trị tăng dần của ask_price 
        <input type="checkbox" id="sort-checkbox2"> Sắp xếp theo giá trị giảm dần của ask_price 
    </label>
    <div id="orderbook"></div>

    <script>
        var sortCheckbox = document.getElementById("sort-checkbox");
        var sortCheckbox2 = document.getElementById("sort-checkbox2");
        var increase = 0;
        var decrease = 0;
                // Xử lý checked của checkbox
        sortCheckbox.addEventListener('change', function() {
            if (this.checked) {
                sortCheckbox2.disabled = true;
                increase = 1;   
            } else {
                increase = 0;
                sortCheckbox2.disabled = false;
            }
        });

        sortCheckbox2.addEventListener('change', function() {
            if (this.checked) {
                sortCheckbox.disabled = true;
                decrease = 1;   
            } else {
                decrease = 0;
                sortCheckbox.disabled = false;
            }
        });

        console.log(increase);
        console.log(decrease);
        

        var orderbookEl = document.getElementById("orderbook");
        var submitBtn = document.getElementById("submit-btn");

        //disable
        submitBtn.disabled = true;

        // Lấy phần tử HTML để chọn cặp tiền
        var pairEl = document.getElementById("pair");
        // Xử lý sự kiện khi người dùng thay đổi cặp tiền
        pairEl.addEventListener("change", function() {
            //enable
            submitBtn.disabled = false;

            // Lấy giá trị của cặp tiền được chọn
            var pair = pairEl.value;
            // Gửi yêu cầu AJAX tới tệp orderbook.php để lấy thông tin orderbook
            var xhr = new XMLHttpRequest();
            let url = "orderbook2.php?pair=" + pair;
            xhr.open("GET", url);
            xhr.onload = function() {
            // Cập nhật nội dung của phần tử HTML để hiển thị kết quả
            orderbookEl.innerHTML = xhr.responseText;
            };
            xhr.send();
        });

        //submit event
        submitBtn.addEventListener("click", function(event) {
            // Ngăn chặn sự kiện mặc định của form
            event.preventDefault();

            // Lấy giá trị của cặp tiền được chọn
            var pair = pairEl.value;

            // Gửi yêu cầu AJAX tới tệp orderbook.php để lấy thông tin orderbook
            var xhr = new XMLHttpRequest();
            let url =
            "orderbook2.php?pair=" + pair + "&increase=" + increase + "&decrease=" + decrease;
            xhr.open("GET", url);
            xhr.onload = function() {
            // Cập nhật nội dung của phần tử HTML để hiển thị kết quả
            orderbookEl.innerHTML = xhr.responseText;
            };
            xhr.send();
        });
    </script>



    <?php 
    ?>
</body>
</html>
