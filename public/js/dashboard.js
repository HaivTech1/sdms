
class DashboardActionComponent {
    constructor(
        buttonSelector,
        checkboxSelector,
        url,
        action,
        messageSelector
    ) {
        this.buttonSelector = buttonSelector;
        this.checkboxSelector = checkboxSelector;
        this.url = url;
        this.action = action;
        this.button = document.querySelector(buttonSelector);
        this.message = document.getElementById(messageSelector);
        this.init();
    }

    init() {
        if (this.button) {
            this.button.addEventListener("click", () => this.performAction());
        } else {
            console.error(
                `Button with selector ${this.buttonSelector} not found.`
            );
        }
    }

    getSelectedIds() {
        const selectedIds = [];
        const checkboxes = document.querySelectorAll(
            `${this.checkboxSelector}:checked`
        ); // Filters for checked checkboxes only
        checkboxes.forEach((checkbox) => selectedIds.push(checkbox.dataset.id));
        return selectedIds;
    }

    async performAction() {
        const selectedIds = this.getSelectedIds();
        const messageContent = this.message ? this.message.value : "";

        if (selectedIds.length < 1) {
            this.showAlert("Error!", "Please select at least one row", "error");
            return;
        }

        const confirmed = confirm(
            `Are you sure you want to ${this.action} the selected items?`
        );
        if (confirmed) {
            this.button.setAttribute("disabled", "disabled");
            const originalInnerHTML = this.button.innerHTML;
            this.button.innerHTML = `<i class='ri-folder-upload-line text-white'></i> processing...`;

            try {
                const response = await this.sendActionRequest(
                    selectedIds,
                    messageContent
                );
                this.showAlert(response.title, response.message, "success");
                if (response.status === true) {
                    location.reload();
                }
            } catch (error) {
                console.error("Action request error:", error);
                this.showAlert("Error!", "Something went wrong.", "error");
            } finally {
                this.button.removeAttribute("disabled");
                this.button.innerHTML = originalInnerHTML;
            }
        }
    }

    async sendActionRequest(selectedIds, messageContent) {
        const response = await fetch(this.url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify({
                ids: selectedIds,
                action: this.action,
                message: messageContent,
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    showAlert(title, message, type) {
        toastr[type](message, title);
    }
}
