// public/js/product-search.js

$(function () {
    // 現在のソートカラムとソート方向を管理する変数
    // 初期表示のソート設定に合わせて、'id' と 'asc' または 'desc' を設定してください。
    // index.blade.phpのhiddenフィールドの初期値と合わせるのが良いでしょう。
    let currentSortColumn = $('#sort').val() || 'id'; // hiddenフィールドの値を優先、なければ'id'
    let currentSortDirection = $('#order').val() || 'asc'; // hiddenフィールドの値を優先、なければ'asc'

    // 検索フォーム送信時（Ajax）のイベントハンドラ
    $('#search-form').on('submit', function (e) {
        e.preventDefault(); // フォームの通常の送信を防ぐ
        fetchProducts();  // 商品データを非同期で取得する関数を呼び出す
    });

    // ソートリンククリック時（Ajax）のイベントハンドラ
    // 動的に追加される要素にも対応するため、$(document).on() を使用
    $(document).on('click', '.sort-link', function (e) {
        e.preventDefault(); // リンクの通常の遷移を防ぐ

        // クリックされたソートリンクのdata-column属性からカラム名を取得
        // HTML側がdata-columnとなっているため、ここもdata-columnで取得
        const clickedColumn = $(this).data('column');

        // クリックされたカラムが現在のソートカラムと同じ場合
        if (clickedColumn === currentSortColumn) {
            // ソート方向を昇順（asc）と降順（desc）で切り替える
            currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // 異なるカラムがクリックされた場合、そのカラムを新しいソートカラムに設定し、
            // ソート方向はデフォルトで昇順にする
            currentSortColumn = clickedColumn;
            currentSortDirection = 'asc';
        }

        // フォーム内のhiddenフィールドの値を更新
        $('#sort').val(currentSortColumn);
        $('#order').val(currentSortDirection);

        fetchProducts();  // 更新されたソート条件で商品データを再取得
    });

    // 検索・ソート共通の商品データ取得（Ajax）関数
    function fetchProducts() {
        const form = $('#search-form');
        // フォームデータを配列形式で取得（hiddenフィールドも含む）
        let formData = form.serializeArray();
        
        // formData配列内の'sort'と'order'の値を、現在のソート状態に更新
        // または、もし存在しなければ新しい要素として追加
        let foundSort = false;
        let foundOrder = false;
        for (let i = 0; i < formData.length; i++) {
            if (formData[i].name === 'sort') {
                formData[i].value = currentSortColumn;
                foundSort = true;
            }
            if (formData[i].name === 'order') {
                formData[i].value = currentSortDirection;
                foundOrder = true;
            }
        }
        // もしhiddenフィールドが何らかの理由で存在しない場合のためのフォールバック
        if (!foundSort) {
            formData.push({ name: 'sort', value: currentSortColumn });
        }
        if (!foundOrder) {
            formData.push({ name: 'order', value: currentSortDirection });
        }

        // Ajaxリクエストの実行
        $.ajax({
            url: '/products/search', // バックエンドの検索APIエンドポイント
            type: 'GET', // HTTPメソッドはGET
            // serializeArray()で取得した配列を、$.param()でURLエンコードされたクエリ文字列に変換
            data: $.param(formData),
            dataType: 'html', // サーバーからHTMLの断片が返されることを期待
            success: function (response) {
                // 成功した場合、返されたHTMLで商品テーブルのdivの中身を差し替える
                $('#product-table').html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // エラーが発生した場合の処理
                // デバッグのために、エラーの詳細をコンソールに出力
                console.error("検索に失敗しました:", textStatus, errorThrown, jqXHR.responseText);
                // ユーザーへのアラート表示
                alert('検索に失敗しました');
            }
        });
    }
});
