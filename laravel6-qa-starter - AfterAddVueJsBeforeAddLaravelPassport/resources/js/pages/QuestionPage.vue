<template>
    <div>
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
export default {
    props : {
        question : {
            type : [Object]
        }
    }
}
</script>