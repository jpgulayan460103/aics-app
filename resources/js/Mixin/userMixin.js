import { cloneDeep, isEmpty } from "lodash"

export default {
    props: ["user"],
    data() {
        return {
            userData : {}
        }
    },
    methods: {
        userRole(user){
            if(!isEmpty(user.roles)){
                return user.roles[0].name;
            }
            return null;
        },
        hasRoles(roles = []){
            return roles.includes(this.userData.role)
        }
    },
    mounted() {
        this.userData = cloneDeep(this.user);
        this.userData.role = this.userRole(this.userData);
    }
}