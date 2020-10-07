<template>
    <tr>
        <td class="text-center align-middle"></td>
        <td>{{article.subject}}</td>
        <td>{{(group)?group.name:''}}</td>
        <td>
            <template v-if="group && group.draft">
                <span class="text-danger">{{__("l.Draft")}}</span>
            </template>
            <template v-else>
                <span v-if="article.draft" class="text-danger">{{__("l.Draft")}}</span>
                <span v-else class="text-success">{{__("l.Published")}}</span>
            </template>
        </td>
        <td class="text-center">{{article.created_at|format-date-time}}</td>
        <td class="text-center align-middle">
            <a target="_blank" :href="route('knowledge-base.article', article.slug)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></a>
            <Inertia-link :href="route('knowledge_base.edit', article.id)" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
            <Inertia-link href="#" @click="delete_article(article.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
        </td>
    </tr>
</template>

<script>
export default {
    name: "row",
    props: ["article", "group", "delete_article"],
}
</script>
