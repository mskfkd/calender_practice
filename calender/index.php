<?PHP
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//前月・次月のリンクが押された場合は、GETパラメーターから年月を取得
if(isset($_GET['ym'])) {
	$ym = $_GET['ym'];
} else {
	//今月の年月を表示
	$ym = date('Y-m');
}

//タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if($timestamp === false) {
	$ym = date('Y-m');
	$timestamp = strtotime($ym . '-01');
}

//今日の日付フォーマット
$today = date('Y-m-j');

//カレンダーのタイトルを作成
$html_title = date('Y年n月' , $timestamp);

//前月・次月の年月を取得
$prev = date('Y-m' ,strtotime('-1 month' , $timestamp));
$next = date('Y-m' ,strtotime('+1 month' , $timestamp));

//該当月の日数を取得
$day_count = date('t' , $timestamp);

//1日が何曜日か
$youbi = date('w' , $timestamp);

//カレンダー作成の準備
$weeks = [];
$week = '';

//第一週目:空のセルを追加
$week .= str_repeat('<td></td>', $youbi);

for($day = 1; $day <= $day_count; $day++ , $youbi++) {
	$date = $ym . '-' . $day;

	if($today == $date) {
		//今日の日付の場合は、clss="today"をつける
		$week .= '<td class="today">' . $day;
	}else {
		$week .= '<td>' . $day;
	}
	$week .= '</td>';

	//週終わり、または月終わりの場合
	if($youbi % 7 == 6 || $day == $day_count) {
		if($day == $day_count) {
			//月の最終日の場合、空セルを追加
			$week .= str_repeat('<td></td>', 6 - ($youbi % 7));
		}
	
	//weeks配列にtrと$weekを追加する
	$weeks[] = '<tr>' . $week . '</tr>';

	//weekをリセット
	$week = '';

	}

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>PHPカレンダー</title>
	<link rel="stylesheet" href="CSS/styles.css">
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h3><a href="?ym=<?php echo $prev; ?>">&lt;</a>
			<?php echo $html_title; ?>
			<a href="?ym=<?php echo $next; ?>">&gt;</a>
		</h3>
		<table class="table table-bpordered">
			<tr>
				<th>日</th>
				<th>月</th>
				<th>火</th>
				<th>水</th>
				<th>木</th>
				<th>金</th>
				<th>土</th>
			</tr>
			<?php 
				foreach ($weeks as $week) {
					echo $week;
				}
			?>
		</table>
	</div>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>