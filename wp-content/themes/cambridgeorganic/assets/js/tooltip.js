document.addEventListener('DOMContentLoaded', () => {
    let activeTooltip = null;

    document.addEventListener('mouseenter', (e) => {
        if(!e.target.closest) {
            return;
        }
        const trigger = e.target.closest('[data-tooltip]');
        if (!trigger) {
            return;
        }

        const templateId = trigger.dataset.tooltip;
        const template = document.getElementById(templateId);

        if (!template) {
            return;
        }

        // Remove existing tooltip
        if (activeTooltip) {
            activeTooltip.remove();
        }

        activeTooltip = template.content.firstElementChild.cloneNode(true);
        activeTooltip.classList.add('js-tooltip');

        document.body.appendChild(activeTooltip);

        const triggerRect = trigger.getBoundingClientRect();
        const tooltipWidth = activeTooltip.offsetWidth;
        const tooltipHeight = activeTooltip.offsetHeight;

        const left =
            triggerRect.left -
            (triggerRect.width);

        const top =
            triggerRect.top + (tooltipHeight / 2);

        activeTooltip.style.position = 'fixed';
        activeTooltip.style.left = `${Math.max(10, left)}px`;
        activeTooltip.style.top = `${top}px`;
    }, true);

    document.addEventListener('mouseleave', (e) => {
        if(!e.target.closest) {
            return;
        }
        const trigger = e.target.closest('[data-tooltip]');
        if (!trigger || !activeTooltip) {
            return;
        }

        setTimeout(() => {
            if (
                activeTooltip &&
                !activeTooltip.matches(':hover')
            ) {
                activeTooltip.remove();
                activeTooltip = null;
            }
        }, 100);
    }, true);

    document.addEventListener('mouseover', (e) => {
        if (
            activeTooltip &&
            !e.target.closest('[data-tooltip]') &&
            !e.target.closest('.js-tooltip')
        ) {
            activeTooltip.remove();
            activeTooltip = null;
        }
    });
});