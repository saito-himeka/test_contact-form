@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')

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
                            <button 
                            type="button" 
                            class="btn-detail" 
                            data-bs-toggle="modal" 
                            data-bs-target="#contactModal" 
                            onclick="setModalData(this)"
                            >詳細</button>
                            
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </main>
{{-- ================================================= --}}
{{-- Bootstrap モーダルのHTML構造 --}}
{{-- 独自CSSとの干渉を避けるため、IDを #contactModal に変更 --}}
{{-- ================================================= --}}
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">お問い合わせ詳細</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Bootstrapのdlクラスを使用しつつ、カスタムCSSを適用 --}}
                <dl class="detail-list">
                    <div class="detail-item">
                        <dt>お名前</dt>
                        <dd id="modal-name"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>性別</dt>
                        <dd id="modal-gender"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>メールアドレス</dt>
                        <dd id="modal-email"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>電話番号</dt>
                        <dd id="modal-tel"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>住所</dt>
                        <dd id="modal-address"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>建物名</dt>
                        <dd id="modal-building"></dd>
                    </div>
                    <div class="detail-item">
                        <dt>お問い合わせの種類</dt>
                        <dd id="modal-category"></dd>
                    </div>
                    <div class="detail-item detail-item-full">
                        <dt>お問い合わせ内容</dt>
                        <dd id="modal-detail"></dd>
                    </div>
                </dl>
                
                {{-- 削除フォーム --}}
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    {{-- 💡 confirm() の代わりにカスタムUIの使用を推奨します --}}
                    <button type="submit" class="btn-delete-modal" onclick="return confirm('お問い合わせID: ' + getContactId() + ' を本当に削除しますか？')">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================= --}}
{{-- JavaScript: データ挿入ロジック --}}
{{-- ================================================= --}}
<script>
    let currentContactId = null;

    /**
     * 詳細ボタンクリック時に、<tr>からデータを取得しモーダル要素にセットする
     * @param {HTMLElement} button - クリックされた「詳細」ボタン要素
     */
    function setModalData(button) {
        try {
            const row = button.closest('tr');
            if (!row) throw new Error('Parent row element not found.');
            
            const dataJson = row.getAttribute('data-contact-details');
            if (!dataJson) throw new Error('data-contact-details attribute missing.');

            const data = JSON.parse(dataJson);
            currentContactId = data.id; // 削除確認用IDを保持

            // 1. モーダル内の要素にデータをセット
            document.getElementById('modal-name').textContent = data.name || 'N/A';
            document.getElementById('modal-gender').textContent = data.gender || 'N/A';
            document.getElementById('modal-email').textContent = data.email || 'N/A';
            document.getElementById('modal-tel').textContent = data.tel || 'N/A';
            document.getElementById('modal-address').textContent = data.address || 'N/A';
            document.getElementById('modal-building').textContent = data.building || 'なし';
            document.getElementById('modal-category').textContent = data.category || 'N/A';
            document.getElementById('modal-detail').textContent = data.detail || 'なし';

            // 2. 削除フォームのactionを設定
            const deleteForm = document.getElementById('delete-form');
            if (deleteForm && data.id) {
                // ルートのプレフィックスは環境に合わせて調整
                // 例: /admin/contacts/123
                deleteForm.action = `/admin/contacts/${data.id}`;
            }

        } catch (error) {
            console.error("モーダルデータの設定中にエラーが発生しました:", error.message);
        }
    }

    /**
     * 削除確認ダイアログ内で使用するためのIDを取得するヘルパー関数
     */
    function getContactId() {
        return currentContactId;
    }
    
    // 💡 注意: BootstrapのJavaScriptファイル (bootstrap.bundle.min.js) が
    // このスクリプトよりも後に読み込まれている必要があります。
</script>


@endsection