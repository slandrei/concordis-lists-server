const watchedLists = []; //store watchedLists id

function getWatchedLists() {
    return watchedLists;
}

function addToWatch(toWatch)  {
    toWatch.forEach(id => {
        if(!watchedLists.includes(id)){
            watchedLists.push(id)
        }
    })
}

function removeFromWatch(id)  {
    const index = watchedLists.findIndex(list => list.id === id);

    if (index !== -1) {
        return watchedLists.splice(index, 1)[0];
    }
}




module.exports = {
    getWatchedLists,
    addToWatch,
    removeFromWatch,
};
