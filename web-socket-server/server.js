const express = require('express');
const http =require("http");
const socketio = require('socket.io');
const {
    getWatchedLists,
    addToWatch,
    removeFromWatch,
} = require('./utils/lists');

const {
    decodeAllowedUsers,
    intersect
} = require('./utils/utilities');
const {
    getUsers,
    getUsersForList,
    addListToUser,
    removeListFromUser,
    broadcastTo,
    connectUser,
    disconnectUser
} = require("./utils/users");

const app = express();

const server = http.createServer(app);
const io = socketio(server, {
    cors: {origin: '*'}
});


io.on('connection', socket => {
    console.log('Client connected: ' + socket.id);

    socket.emit('hello', {obj: "Hello friend"});

    socket.on('enter', message => {
        console.log({message})
    })

    socket.on('login', data => {
        console.log({login: data})
        connectUser({
            socketId: socket.id,
            ...data
        })
        const users = getUsers();
        console.log(users)
    })

    //Deleting list
    socket.on('deleted_list', id => {
        const watchers = getUsersForList(id, socket.id);
        watchers.forEach(sock => {
            socket.to(sock.id).emit(`user-${sock.userId}-deletedList`, id);
        })
    })

    //Editing list
    socket.on('edited_list', editedList => {
        const watchers = getUsersForList(editedList.id, socket.id);
        watchers.forEach(sock => {
            socket.to(sock.id).emit(`user-${sock.userId}-editedList`, editedList);
        })
    })

    //Adding item to list
    socket.on('added_item', item => {
        const watchers = getUsersForList(item.list_id, socket.id);
        watchers.forEach(sock => {
            socket.to(sock.id).emit(`user-${sock.userId}-addedItem`, item);
        })
    })

    //Removing item from list
    socket.on('removed_item', data => {
        const watchers = getUsersForList(data.list_id, socket.id);
        watchers.forEach(sock => {
            socket.to(sock.id).emit(`user-${sock.userId}-removedItem`, data.id);
        })
    })

    //Editing item from list
    socket.on('edited_item', editedItem => {
        const watchers = getUsersForList(editedItem.list_id, socket.id);
        watchers.forEach(sock => {
            socket.to(sock.id).emit(`user-${sock.userId}-editedItem-${editedItem.id}`, editedItem);
        })
    })

    socket.on('logout', () => {
        disconnectUser(socket.id)
        console.log('Logged out: ' + socket.id)
    })

    socket.on('disconnect', () => {
        disconnectUser(socket.id)
        console.log('Disconnected: ' + socket.id)
    })
})


const PORT = process.env.PORT || 3001;
server.listen(PORT, () => console.log(`Web socket server started on port: ${PORT}...`));
