const {list} = require("postcss");
const users = [];

function getUsers(){
    return users;
}

function connectUser(user){
    users.push(user)
}

function disconnectUser(id){
    const index = users.findIndex(user => user.socketId === id);

    if (index !== -1) {
        return users.splice(index, 1)[0];
    }
}

function getUsersForList(id, without = null){
    const ids = [];
    users.forEach(user => {
        if(user.lists.includes(id) && user.socketId !== without){
            ids.push({
                id: user.socketId,
                userId: user.id
            })
        }
    })
    return ids;
}

function broadcastTo(socket, to, identifier, data){
    to.forEach(recipient => {
        if(socket.id !== recipient.id){
            socket.to(recipient.id, identifier, data)
        }
    })
}

function addListToUser(sockId, newList){
    users.map(user => {
        if(user.socketId === sockId){
            user.lists =  [...user.lists, newList];
        }
        return user
    })
}

function removeListFromUser(sockId, listId){
    users.map(user => {
        if(user.socketId === sockId){
            user.lists =  user.lists.filter(id => id !== listId)
        }
        return user
    })
}

module.exports = {
    getUsers,
    getUsersForList,
    addListToUser,
    removeListFromUser,
    broadcastTo,
    connectUser,
    disconnectUser
}




