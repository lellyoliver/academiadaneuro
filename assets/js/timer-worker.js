let timer;
let seconds = 0;

self.onmessage = function (e) {
    const { command, interval, reset } = e.data;

    if (command === 'start') {
        if (reset) {
            seconds = 0;
        }
        timer = setInterval(() => {
            seconds++;
            self.postMessage(seconds);
        }, interval);
    } else if (command === 'stop') {
        clearInterval(timer);
    } else if (command === 'reset') {
        clearInterval(timer);
        seconds = 0;
    }
};
