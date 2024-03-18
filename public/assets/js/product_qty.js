
const addQ = (e) => {
    const input = e.target.previousElementSibling;
    let value = parseInt(input.value);

    input.value = value + 1;
}

const minisQ = (e) => {
    const input = e.target.nextElementSibling;
    let value = parseInt(input.value);

    if(value > 1) {
        input.value = value - 1;
    }
}


