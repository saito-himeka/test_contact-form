@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">ログアウト</button>
</form>

<main class="container">
        <h2 class="page-title">Admin</h2>

    <!-------------検索フォーム------------->
        <form class="search-form" action="{{ route('admin.index') }}" method="GET">
            @csrf

            <!-- 1, 2: 名前・メールアドレス検索 (一つのinputにまとめる) -->
            <input type="text" name="search_keyword" class="input-text" placeholder="名前やメールアドレスを入力してください" value="{{ request('search_keyword') }}">
            
            <!-- 3: 性別 -->
            <select class="select-box" name="gender">
                <option value="">性別</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>

            <!-- 4: お問い合わせの種類 (動的生成 & category_idを使用) -->
            <select name="category_id" class="select-box">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $category)
                <option 
                    value="{{ $category->id }}" 
                    {{ (int)request('category_id') === $category->id ? 'selected' : '' }}
                >
                    {{ $category->content }}
                </option>
            @endforeach
            </select>

            <!-- 5: 日付 -->
            <input type="date" name="date" class="select-box" value="{{ request('date') }}">
            {{--<select class="select-box">
                <option value="">年/月/日</option>
            </select>--}}

            <button type="submit" class="btn-search">検索</button>

            <!-- リセットボタン (検索パラメータなしでGETリクエスト) -->
            <a href="{{ route('admin.index') }}">
            <button type="button" class="btn-reset">リセット</button>
            </a>
        </form>

        <div class="action-bar">
            <!-- FN024: エクスポートボタン (現在の検索条件を渡す) -->
            <a href="{{ route('admin.contacts.export', request()->query()) }}" class="btn-export">
                <button class="btn-export">エクスポート</button>
            </a>
            <!-- FN021: ページネーションリンク -->
            <div class="pagination">
                {{ $contacts->links('vendor.pagination.default') }} 
                {{-- default テンプレートを使用 (環境に合わせて変更) --}}
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th> </tr>
                </thead>
                <tbody>
                    <!-- FN021: 動的な一覧表示 -->
                    @foreach ($contacts as $contact)
                    <tr data-contact-details="{{ json_encode([
                        'id' => $contact->id,
                        'name' => $contact->last_name . ' ' . $contact->first_name,
                        'gender' => $contact->gender_jp,
                        'email' => $contact->email,
                        'tel' => $contact->tel,
                        'address' => $contact->address,
                        'building' => $contact->building,
                        'category' => $contact->category->content ?? '不明',
                        'detail' => $contact->detail,
                    ]) }}">
                        <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                        <td>{{ $contact->gender_jp }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->category->content ?? '不明' }}</td>
                        <td>
                            <!-- FN023: 詳細ボタン -->
                            <button type="button" class="btn-detail" onclick="openModal(this)">詳細</button>
                            {{--
                            <!-- FN026: 削除ボタン -->
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display:inline;" onsubmit="return confirm('お問い合わせID: {{ $contact->id }} を本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">削除</button>
                            </form>--}}
                        </td>
                    </tr>
                    @endforeach
                    {{--<tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>--}}
                    
                </tbody>
            </table>
        </div>
    </main>

<!-- FN023, FN025: モーダルウィンドウのHTML構造 -->
<div id="contact-modal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">×</button>
        <h3>お問い合わせ詳細</h3>
        <div id="modal-details">
            <!-- 詳細データがここにJSで挿入されます -->
        </div>
    </div>
</div>

<script>
    // FN023, FN025: モーダル表示/非表示ロジック
    const modal = document.getElementById('contact-modal');
    const modalDetails = document.getElementById('modal-details');
    const triggerButtons = document.querySelectorAll('.js-modal-trigger');
    const closeButton = document.getElementById('modal-close-btn');
    const deleteForm = document.getElementById('delete-form');
    // Laravelのルーティングヘルパー関数がJSから使えないため、削除ルートのベースをここで定義
    const deleteRouteBase = "{{ route('admin.contacts.destroy', ['contact' => 'DUMMY_ID']) }}";


    function openModal(button) {
        const row = button.closest('tr');
        if (!row) return;

        let data = {};
        try {
            data = JSON.parse(row.dataset.contactDetails);
        } catch (e) {
            console.error("JSONデータのパースエラー:", e);
            return;
        }

        // 詳細情報のHTMLを生成
        modalDetails.innerHTML = `
            <div class="modal-detail-row">
                <div class="modal-detail-label">お名前</div><div class="modal-detail-value">${data.name}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">性別</div><div class="modal-detail-value">${data.gender}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">メールアドレス</div><div class="modal-detail-value">${data.email}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">電話番号</div><div class="modal-detail-value">${data.tel || 'N/A'}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">住所</div><div class="modal-detail-value">${data.address || 'N/A'}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">建物名</div><div class="modal-detail-value">${data.building || 'N/A'}</div>
            </div>
            <div class="modal-detail-row">
                <div class="modal-detail-label">お問い合わせの種類</div><div class="modal-detail-value">${data.category}</div>
            </div>
            <div class="modal-detail-row detail-content-row">
                <div class="modal-detail-label">お問い合わせ内容</div><div class="modal-detail-value detail-content-value">${data.detail}</div>
            </div>
        `;
        
        // 削除フォームの action URL を設定
        // DUMMY_ID を実際のIDに置き換える
        const deleteUrl = deleteRouteBase.replace('DUMMY_ID', data.id);
        deleteForm.setAttribute('action', deleteUrl);

        modal.style.display = 'flex'; // モーダルを表示
    }

    function closeModal() {
        modal.style.display = 'none'; // モーダルを非表示
    }

    // ページ読み込み完了後にイベントリスナーを設定
    document.addEventListener('DOMContentLoaded', () => {
        // 1. 詳細ボタンにクリックイベントを設定
        triggerButtons.forEach(button => {
            button.addEventListener('click', function() {
                openModal(this);
            });
        });

        // 2. 閉じるボタンにイベントを設定
        closeButton.addEventListener('click', closeModal);

        // 3. モーダル外をクリックで閉じる処理
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }
    });
</script>
@endsection