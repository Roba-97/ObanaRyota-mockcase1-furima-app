const saveDraftRequest = function (jsonData) {
    const chatInput = document.getElementById('chat-input');
    const chatRoomId = jsonData.id;
    const saveDraftUrl = `/chat/${chatRoomId}/draft`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let isSubmitting = false;

    const formIdArray = ['js-message-send-form', 'js-rating-form', 'js-message-control-form'];
    formIdArray.forEach((form) => {
        let formElement = document.getElementById(form);
        formElement.addEventListener('submit', function () {
            isSubmitting = true;
        });
    });

     // ページを離れる時にドラフトを保存する
    window.addEventListener('pagehide', function (e) {
        // フォーム送信時は何もしない
        if (isSubmitting) {
            return;
        }

        // 入力欄に何かテキストがある場合のみ実行
        if (chatInput.value.trim() !== '') {
            const formData = new FormData();
            formData.append('draft', chatInput.value);
            formData.append('_token', csrfToken); // CSRFトークンを忘れずに
            navigator.sendBeacon(saveDraftUrl, formData);
        }
    });
}