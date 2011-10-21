
/*

 */

Library.loadElement(); //

var DIALOG_TYPE_NONE = 0;
var DIALOG_TYPE_OK = 1;
var DIALOG_TYPE_OK_CANCEL = 2;
var DIALOG_TYPE_OK_IGNORE_CANCEL = 3;
var DIALOG_TYPE_CANCEL = 4;

var Dialog = {
	id: 'library_dialog',
	message: null,
	text_message_type: true,
	type: DIALOG_TYPE_OK,
	text_Ok: 'Ok',
	text_Cancel: 'Cancel',
	text_Ignore: 'Ignore',
	id_Wrapper: 'library_dialog_wrapper',
	id_Message: 'library_dialog_message',
	id_Buttons: 'library_dialog_buttons',
	id_Ok: 'dialog_ok_button',
	id_Cancel: 'dialog_cancel_button',
	id_Ignore: 'dialog_ignore_button',
	onShow: function() {},
	onHide: function() {},
	onOk: function() { Dialog.hide(); },
	onCancel: function() { Dialog.hide(); },
	onIgnore: function() { Dialog.hide(); },
	show: function() {
/*
		dialogWrapper = document.createElement('div');
		dialogContainer = document.createElement('div');
		messageContainer = document.createElement('div');
		dialogWrapper.setAttribute('id', this.id_Wrapper);
		dialogContainer.setAttribute('id', this.id);
		messageContainer.setAttribute('id', this.id_Message);
*/
		dialogWrapper = Element.createDiv(this.id_Wrapper);
		dialogContainer = Element.createDiv(this.id);
		messageContainer = Element.createDiv(this.id_Message);

		if (this.type != DIALOG_TYPE_NONE) {
/*
			buttonsContainer = document.createElement('div');
			buttonsContainer.setAttribute('id', this.id_Buttons);
*/
			buttonsContainer = Element.createDiv(this.id_Buttons);
		}

		if (this.type != DIALOG_TYPE_NONE && this.type != DIALOG_TYPE_CANCEL) {
/*
			okButton = document.createElement('input');
			okButton.setAttribute('id', this.id_Ok);
			okButton.setAttribute('type', 'button');
			okButton.setAttribute('value', this.text_Ok);
*/
			okButton = Element.createButton(this.text_Ok, this.id_Ok);

			Action.onclick(okButton, this.onOk);
			buttonsContainer.appendChild(okButton);
		}

		if (this.type != DIALOG_TYPE_OK && this.type != DIALOG_TYPE_NONE) {
/*
			cancelButton = document.createElement('input');
			cancelButton.setAttribute('id', this.id_Cancel);
			cancelButton.setAttribute('type', 'button');
			cancelButton.setAttribute('value', this.text_Cancel);
*/
			cancelButton = Element.createButton(this.text_Cancel, this.id_Cancel);

			Action.onclick(cancelButton, this.onCancel);
			buttonsContainer.appendChild(cancelButton);
		}
		if (this.type == DIALOG_TYPE_OK_IGNORE_CANCEL) {
/*
			ignoreButton = document.createElement('input');
			ignoreButton.setAttribute('id', this.id_Ignore);
			ignoreButton.setAttribute('type', 'button');
			ignoreButton.setAttribute('value', this.text_Ignore);
*/
			ignoreButton = Element.createButton(this.text_Ignore, this.id_Ignore);

			Action.onclick(ignoreButton, this.onIgnore);
			buttonsContainer.appendChild(ignoreButton);
		}

		if (this.text_message_type) {
			messageContainer.appendChild(document.createTextNode(this.message));
		}
		else {
			messageContainer.innerHTML = this.message;
		}

		dialogContainer.appendChild(messageContainer);
		if (this.type != DIALOG_TYPE_NONE) dialogContainer.appendChild(buttonsContainer);
		dialogWrapper.appendChild(dialogContainer);
		$$('body')[0].appendChild(dialogWrapper);
		this.onShow();
	},
	hide: function() {
		if ($(this.id_Wrapper) != null) $$('body')[0].removeChild($(this.id_Wrapper));
		this.onHide();
	}
}

Library.onDialogLoad();

