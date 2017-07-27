import React from 'react';
import { render } from 'react-dom';

import Locator from 'components/Locator';

const container = document.querySelector('.locator');

const boot = () => (
    render((
        <Locator/>
    ), container)
);

const loadedStates = ['complete', 'loaded', 'interactive'];
if (loadedStates.includes(document.readyState) && document.body) {
    boot();
} else {
    window.addEventListener('DOMContentLoaded', boot, false);
}