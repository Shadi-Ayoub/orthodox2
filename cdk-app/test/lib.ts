export function print(obj: any) {
    Object.prototype.toString = function(){
        return JSON.stringify(this, undefined, 4)
    }

    console.log(`${obj.key}: ` + obj.value.toString());
}