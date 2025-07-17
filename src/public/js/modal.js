// 取引完了モーダル
const openDealModal = function () {
    const modal = document.getElementById("js-chat-deal-modal");
    modal.style.display = "block";
}

// メッセージ編集・削除モーダル
const openMessageControlModal = function (mode, jsonData, optional='') {
    const heading = document.getElementById("js-message-control-heading");
    const form = document.getElementById("js-message-control-form");
    const textarea = document.getElementById("js-message-textarea");
    const img = document.getElementById("js-delete-img");
    const button = document.getElementById("js-message-control-submit-button");
    const inputId = document.getElementById("js-message-id-input");
    const errorText = document.getElementById("js-modal-error-message");
    const modal = document.getElementById("js-message-control-modal");

    textarea.style.display = "block";
    img.style.display = "none";
    errorText.style.display = "none";
    modal.style.display = "block"

    form.action = `/chat/${jsonData.id}`;
    textarea.textContent = jsonData.content;
    inputId.setAttribute("value", jsonData.id);

    switch (mode) {
        case "edit":
            heading.textContent = "メッセージを編集する";
            setFormMethod(form, 'PATCH');
            button.textContent = "編集";
            button.style.background = "#0073CC"
            textarea.removeAttribute("readonly");
            textarea.style.outline = "";
            break;
        case "delete":
            heading.textContent = "メッセージを削除する";
            setFormMethod(form, 'DELETE');
            textarea.setAttribute("readonly", "");
            textarea.style.outline = "none";
            button.textContent = "削除";
            button.style.background = "#FF8282"
            break;
        case "delete-img":
            heading.textContent = "画像を削除する";
            setFormMethod(form, 'DELETE');
            textarea.style.display = "none";
            img.style.display = "block";
            button.textContent = "削除";
            button.style.background = "#FF8282"
        default:
            break;
    }

    if (jsonData.content_type === 2 && optional !== '') {
        img.setAttribute("src", optional);
    } else if (optional !== '') {
        errorText.textContent = optional
        errorText.style.display = "block";
    }
}

// モーダルを閉じる
function closeModal() {
    const modal = document.getElementById("js-message-control-modal");
    modal.style.display = "none";
}

/**
 * フォームにHTTPメソッドを指定する隠しフィールドを追加
 * @param {HTMLFormElement} form - 対象のフォーム要素
 * @param {string} method - 'PATCH', 'DELETE' などのHTTPメソッド
 */
function setFormMethod(form, method) {
    // 既存のフィールドを一度クリアする
    const existingMethodInput = form.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        existingMethodInput.remove();
    }

    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = method.toUpperCase();
    form.appendChild(methodInput);
}