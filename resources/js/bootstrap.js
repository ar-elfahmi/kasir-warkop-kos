window.axios = {
    defaults: { headers: { common: { 'X-Requested-With': 'XMLHttpRequest' } } },
    get: () => Promise.resolve(),
    post: () => Promise.resolve(),
};
