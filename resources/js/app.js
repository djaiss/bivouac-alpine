import './bootstrap';

import Alpine from 'alpinejs';
import ajax from '@imacrayon/alpine-ajax';
import focus from '@alpinejs/focus'

window.Alpine = Alpine;

Alpine.plugin(ajax, focus);
Alpine.start();
