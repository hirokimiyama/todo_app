import * as Vue from "vue";
import { ref } from "vue";

const application = {
    setup() {
        const registerForm = ref();
        const loginForm = ref();
        
        // 新規登録用の変数
        const registerId = ref("");
        const registerPassword = ref("");

        // ログイン用の変数
        const loginId = ref("");
        const loginPassword = ref("");

        let registerSubmit = function () {
            if (registerId.value == "") {
                alert("id を入力してください。");
                return;
            }
            // 修正：registerPassword.value に変更
            if (registerPassword.value == "") {
                alert("password を入力してください。");
                return;
            }

            registerForm.value.submit();
        };

        let loginSubmit = function () {
            if (loginId.value == "") {
                alert("id を入力してください。");
                return;
            }
            // 修正：loginPassword.value に変更
            if (loginPassword.value == "") {
                alert("password を入力してください。");
                return;
            }
            loginForm.value.submit();
        };

        return {
            registerForm,
            loginForm,

            registerId,
            registerPassword,
            loginId,
            loginPassword,

            registerSubmit,
            loginSubmit,
        };
    },
};

Vue.createApp(application).mount("#login");