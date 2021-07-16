<?php

//Getting a list of products in the form of an associative array
function goods_data($connect)
{
    $query = "SELECT * FROM goods_list";
    $result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_NUM);
    return $result;
}

//Displaying products from the list
function goods_print($connect)
{
    $goods_list = goods_data($connect);
    for ($i = 0; $i < count($goods_list); $i++) {
        echo
            "<form action=\"\" method=\"post\" class=\"goods_item_wrapper\">
			<div id=\"goods_img\">
				<p class=\"goods_img_name\">Image&nbsp;" . $goods_list[$i][2] . "</p>
			</div>
			<h3 class=\"goods_name\">" . $goods_list[$i][2] . "</h3>
			<p class=\"goods_cost\"><b>Price:</b>&nbsp;" . $goods_list[$i][3] . "&nbsp;USD$</p>
			<p class=\"goods_value\"><b>Left:</b>&nbsp;" . $goods_list[$i][4] . "</p>
			<input type=\"hidden\" name=\"goods_id\" value=\"" . $goods_list[$i][0] . "\">
			<div class=\"value_of_goods\">
				<p>Specify the number of products</p>
				<input type=\"number\" name=\"value_of_goods\">
			</div>
			<button type=\"submit\" name=\"buy_goods\" value=\"buy_goods\">Buy</button>
		</form>";
    }
}

//Purchase function
function buy_goods($connect)
{
    if ((isset($_POST['buy_goods'])) && (isset($_POST['goods_id'])) && (isset($_POST['value_of_goods']))) {
        $balance_query = "SELECT * FROM users WHERE user_id = '" . $_SESSION['user_data']['user_id'] . "'";
        $result = mysqli_query($connect, $balance_query);
        $result = mysqli_fetch_assoc($result);
        $balance = $result['user_balance'];

        $item_query = "SELECT * FROM goods_list WHERE goods_id = '" . $_POST['goods_id'] . "'";
        $result = mysqli_query($connect, $item_query);
        $result = mysqli_fetch_assoc($result);
        $item_cost = $result['goods_cost'];
        $item_value = $result['goods_value'];
        $trade_date = date('Y-m-d H:i:s');

        if (isset($_POST['value_of_goods'])) {
            $goods_volume = (double)$_POST['value_of_goods'];
        } else {
            $goods_volume = 0;
        }
        $trade_costs = $item_cost * $goods_volume;

        if (($goods_volume <= $item_value) && ($balance >= $trade_costs) && ($goods_volume > 0)) {
            $trade_query = "INSERT INTO trade_list VALUES (NULL, '" . $_SESSION['user_data']['user_id'] . "', '" . $_POST['goods_id'] . "', '" . $goods_volume . "', '" . $trade_costs . "', '" . $trade_date . "')";
            $trade_result = mysqli_query($connect, $trade_query) or die(mysqli_error($connect));

            $new_user_balance = $balance - $trade_costs;
            $balance_query = "UPDATE users SET user_balance = '" . $new_user_balance . "' WHERE users.user_id = '" . $_SESSION['user_data']['user_id'] . "'";
            $balance_result = mysqli_query($connect, $balance_query) or die(mysqli_error($connect));

            $new_goods_value = $item_value - $goods_volume;
            $goods_query = "UPDATE goods_list SET goods_value = '" . $new_goods_value . "' WHERE goods_list.goods_id = '" . $_POST['goods_id'] . "'";
            $goods_result = mysqli_query($connect, $goods_query) or die(mysqli_error($connect));

            unset($_POST['buy_goods']);
            unset($_POST['goods_id']);
            unset($_POST['value_of_goods']);
        }
    }
}
