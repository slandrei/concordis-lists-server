

function decodeAllowedUsers(toDecode) {
    const decoded = toDecode.split(",");

    const users = [];

    decoded.forEach((user) => {
        if (user && user !== ":") {
            users.push(parseInt(user.substr(1, user.length - 2)));
        }
    });

    return users;
};

function intersect(a, b){
    if(!Array.isArray(a) || !Array.isArray(b)){
        return [];
    }
    if(a.length < b.length){
        return a.filter(el => b.includes(el))
    }
    else{
        return b.filter(el => a.includes(el))
    }
}

module.exports = {decodeAllowedUsers, intersect}


