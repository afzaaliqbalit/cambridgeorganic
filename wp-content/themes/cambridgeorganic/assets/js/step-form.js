/**
 * StepFormEngine: A lightweight, stateful Multi-Step Form Engine.
 * Decouples the markup layout from Javascript by referencing HTML <template> elements!
 */
class StepFormEngine {
    constructor(config) {
        this.container = document.querySelector(config.containerSelector);
        this.steps = config.steps;
        this.totalProgressDots = config.totalProgressDots || this.steps.length;
        this.initialData = config.initialData || {};

        this.onCancelCallback = config.onCancel || (() => {});
        this.onCompleteCallback = config.onComplete || (() => {});
        this.onStateChangeCallback = config.onStateChange || (() => {});
        this.containerClass = config.containerClass || '';

        this.currentStepIndex = config.initialStepIndex || 0;
        this.renderDelay = config.renderDelay || 0;

        this.reset();
    }

    reset() {
        //this.currentStepIndex = 0;
        this.data = JSON.parse(JSON.stringify(this.initialData)); // Deep clone state
        this.render();
        this.notifyStateChange();
    }

    getCurrentStep() {
        return this.steps[this.currentStepIndex];
    }

    setDataValue(key, value) {
        this.data[key] = value;
        this.notifyStateChange();
    }

    getData() {
        return this.data;
    }

    goToStep(index) {
        if (index >= 0 && index < this.steps.length) {
            this.currentStepIndex = index;
            this.render();
            this.notifyStateChange();
        }
    }

    next() {
        const currentStep = this.getCurrentStep();

        // Custom validator checks written in JSON configuration files
        if (currentStep.validate && !currentStep.validate(this.data)) {
            this.showErrorToast(currentStep.validationMessage || "Please complete all choices to proceed.");
            return;
        }

        if (this.currentStepIndex < this.steps.length - 1) {
            this.currentStepIndex++;
            this.render();
            this.notifyStateChange();
        } else {
            this.onCompleteCallback(this.data);
        }
    }

    prev() {
        if (this.currentStepIndex > 0) {
            this.currentStepIndex--;
            this.render();
            this.notifyStateChange();
        } else {
            this.onCancelCallback();
        }
    }

    notifyStateChange() {
        this.onStateChangeCallback({
            currentStepIndex: this.currentStepIndex,
            currentStepId: this.getCurrentStep() ? this.getCurrentStep().id : null,
            data: this.data,
            totalSteps: this.steps.length
        });
    }

    showErrorToast(message) {
        const toastPortal = document.getElementById('toast-portal');
        const toast = document.createElement('div');
        toast.className = "toast align-items-center text-white bg-danger border-0 show m-2";
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.style.pointerEvents = "auto";

        toast.innerHTML = `
                    <div class="d-flex p-3">
                        <div class="toast-body d-flex align-items-center gap-2">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <span class="small fw-bold">${message}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;

        toastPortal.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }

    renderProgressDots() {
        let dotsHtml = '<div class="dots-wrapper">';
        for (let i = 0; i < this.totalProgressDots; i++) {
            const isActive = i <= this.currentStepIndex;
            if (isActive) {
                dotsHtml += `
                            <div class="progress-dot-active">
                                <div class="progress-dot-active-outer"></div>
                                <div class="progress-dot-active-inner"></div>
                            </div>
                        `;
            } else {
                dotsHtml += `<div class="progress-dot-inactive"></div>`;
            }

            if (i < this.totalProgressDots - 1) {
                const lineClass = (i < this.currentStepIndex) ? "filled" : "empty";
                dotsHtml += `<div class="progress-dot-line ${lineClass}"></div>`;
            }
        }
        dotsHtml += '</div>';
        return dotsHtml;
    }

    render() {
        const currentStep = this.getCurrentStep();
        if (!currentStep) return;

        // Remove active class from all steps
        const steps = this.container.querySelectorAll('.switch-js-form > div');
        steps.forEach(step => step.classList.remove('active'));

        // Show current step
        const currentStepEl = document.getElementById(currentStep.templateId);

        setTimeout(()=>{
            if (currentStepEl) {
                currentStepEl.classList.add('active');
                this.container.classList.add('init');

                // Populate data
                if (currentStep.populate) {
                    currentStep.populate(currentStepEl, this.data, this);
                }

                // Bind events
                if (currentStep.bindEvents) {
                    currentStep.bindEvents(currentStepEl, this.data, this);
                }
            }
        },this.renderDelay)


        // Update progress dots if needed
        const dotsContainer = this.container.querySelector('.dots-wrapper');
        if (dotsContainer) {
            dotsContainer.outerHTML = this.renderProgressDots();
        }

        // Global cancel action
        const closeBtn = document.getElementById('form-engine-close-btn');
        if (closeBtn) {
            closeBtn.onclick = () => this.onCancelCallback();
        }

        this.container.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;

            // Prevent double-click
            if (btn.dataset.processing === 'true') return;
            btn.dataset.processing = 'true';

            try {
                switch (btn.dataset.action) {
                    case 'cancel':
                        if(e.target.closest('.swal2-container').querySelector('.swal2-close')) {
                            Swal.close();
                        }
                        this.onCancelCallback();
                        break;

                    case 'prev':
                        this.prev();
                        break;

                    case 'next':
                        this.next();
                        break;
                }
            } finally {
                // Unlock after current event cycle
                setTimeout(() => {
                    delete btn.dataset.processing;
                }, 300);
            }
        });
    }

    render_() {
        const currentStep = this.getCurrentStep();
        if (!currentStep) return;

        // Create shell layout card inside the host container
        this.container.innerHTML = `
                    <div class="brand-form-card ${this.containerClass} animate-fade-in">

                        <!-- Empty sandbox ready for Template cloning -->
                        <div id="step-content-viewport"></div>

                        <!-- Centralized indicator dots -->
                        ${this.renderProgressDots()}
                    </div>
                `;

        // Retrieve and clone step template element
        const template = document.getElementById(currentStep.templateId);
        if (template) {
            const clone = template.content.cloneNode(true);

            // Populate data properties in cloned nodes
            if (currentStep.populate) {
                currentStep.populate(clone, this.data, this);
            }

            // Bind event callbacks in cloned nodes
            if (currentStep.bindEvents) {
                currentStep.bindEvents(clone, this.data, this);
            }

            // Append the populated template fragment inside viewport
            const viewport = this.container.querySelector('#step-content-viewport');
            viewport.appendChild(clone);
        }

        // Global Cancel action
        const closeBtn = document.getElementById('form-engine-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.onCancelCallback());
        }
    }
}

window.switch_js_form = (id, index = 0) => {
    const parent = document.getElementById(id);
    if (!parent) return;
    const children = Array.from(parent.children);

    // Remove active class from all children
    children.forEach(child => {
        child.classList.remove('active');
    });
    // Add active class to the selected child
    if (children[index]) {
        children[index].classList.add('active');
    }
};