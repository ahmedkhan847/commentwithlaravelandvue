<template>
<div class="comments-app">
    <h1>Comments</h1>

    <!-- From -->
    <div class="comment-form">
        <!-- Comment Avatar -->
        <div class="comment-avatar">
            <img src="storage/commentbox.png">
        </div>

        <form class="form" name="form">
            <div class="form-row">
                <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                <span class="input" v-if="errorComment" style="color:red">{{errorComment}}</span>
            </div>

            <div class="form-row">
                <input class="input" placeholder="Email" type="text" :value="user.name">
            </div>

            <div class="form-row">
                <input type="button" @click="saveComment" value="Add Comment">
            </div>
        </form>
    </div>
    <!-- Comments List -->
    <div class="comments" v-if="comments" v-for="(comment,index) in commentsData">
        <!-- Comment -->
        <div v-if="!spamComments[index] || !comment.spam" class="comment">
            <!-- Comment Avatar -->
            <div class="comment-avatar">
                <img src="storage/comment.png">
            </div>

            <!-- Comment Box -->
            <div class="comment-box">
                <div class="comment-text">{{comment.comment}} and {{index}}</div>
                <div class="comment-footer">
                    <div class="comment-info">
                        <span class="comment-author">
                                <em>{{ comment.name}}</em>
                            </span>
                        <span class="comment-date">10-5-6</span>
                    </div>

                    <div class="comment-actions">
                        <ul class="list">
                            <li>Votes: {{comment.votes}}
                                <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'up')">Up Votes</a>
                                <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'down')">Down Votes</a>
                            </li>
                            <li>
                                <a v-on:click="spamComment(comment.commentId,'directcomment',index,0)">Spam</a>
                            </li>
                            <li>
                                <a v-on:click="openComment(index)">Reply</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- From -->
            <div class="comment-form comment-v" v-if="commentBoxs[index]">
                <!-- Comment Avatar -->
                <div class="comment-avatar">
                    <img src="storage/comment.png">
                </div>

                <form class="form" name="form">
                    <div class="form-row">
                        <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                        <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                    </div>

                    <div class="form-row">
                        <input class="input" placeholder="Email" type="text" :value="user.name">
                    </div>

                    <div class="form-row">
                        <input type="button" v-on:click="replyComment(comment.commentid,index)" value="Add Comment">
                    </div>
                </form>
            </div>
            <!-- Comment - Reply -->
            <!--<div v-if="viewcomment[index]">-->
                <div class="comments" v-if="comment.replies" v-for="(replies,index2) in comment.replies">
                    <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">

                        <!-- Comment Avatar -->
                        <div class="comment-avatar">
                            <img src="storage/comment.png">
                        </div>

                        <!-- Comment Box -->
                        <div class="comment-box">
                            <div class="comment-text">{{replies.comment}}</div>
                            <div class="comment-footer">
                                <div class="comment-info">
                                    <span class="comment-author">
                                            {{replies.name}}
                                        </span>
                                    <span class="comment-date">Feb 2, 2013 11:32:04 PM</span>
                                </div>

                                <div class="comment-actions">
                                    <ul class="list">
                                        <li>Total votes: {{replies.votes}}
                                            <a v-if="!replies.votedByUser" v-on:click="voteComment(replies.commentid,'replycomment',index,index2,'up')">Up Votes</a>
                                            <a v-if="!replies.votedByUser" v-on:click="voteComment(comment.commentid,'replycomment',index,index2,'down')">Down Votes</a>
                                            </a>
                                        </li>
                                        <li>
                                            <a v-on:click="spamComment(replies.commentid,'replycomment',index,index2)">Spam</a>
                                        </li>
                                        <li>
                                            <a v-on:click="replyCommentBox(index2)">Reply</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- From -->
                        <div class="comment-form reply" v-if="replyCommentBoxs[index2]">
                            <!-- Comment Avatar -->
                            <div class="comment-avatar">
                                <img src="storage/comment.png">
                            </div>

                            <form class="form" name="form">
                                <div class="form-row">
                                    <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                                    <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                                </div>

                                <div class="form-row">
                                    <input class="input" placeholder="Email" type="text" :value="user.name">
                                </div>

                                <div class="form-row">
                                    <input type="button" v-on:click="replyComment(comment.commentid,index)" value="Add Comment">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->

</template>

<script>
var _ = require('lodash');
export default {
    props: ['commentUrl'],
    data() {
        return {
            comments: [],
            commentreplies: [],
            comments: 0,
            commentBoxs: [],
            message: null,
            replyCommentBoxs: [],
            commentsData: [],
            viewcomment: [],
            show: [],
            spamCommentsReply: [],
            spamComments: [],
            errorComment: null,
            errorReply: null,
            user: window.user
        }
    },
    http: {
        headers: {
            'X-CSRF-TOKEN': window.csrf
        }
    },
    methods: {
        fetchComments() {
            this.$http.get('comments/' + this.commentUrl).then(res => {

                this.commentData = res.data;
                this.commentsData = _.orderBy(res.data, ['votes'], ['desc']);
                this.comments = 1;
                console.log(this.commentData[0].replies[0]);
            });
            
        },
        showComments(index) {
            if (!this.viewcomment[index]) {
                Vue.set(this.show, index, "hide");
                Vue.set(this.viewcomment, index, 1);
            } else {
                Vue.set(this.show, index, "view");
                Vue.set(this.viewcomment, index, 0);
            }
        },
        openComment(index) {
            if (this.user) {
                if (this.commentBoxs[index]) {
                    Vue.set(this.commentBoxs, index, 0);
                } else {
                    Vue.set(this.commentBoxs, index, 1);
                }
            }

        },
        replyCommentBox(index) {
            if (this.user) {
                if (this.replyCommentBoxs[index]) {
                    Vue.set(this.replyCommentBoxs, index, 0);
                } else {
                    Vue.set(this.replyCommentBoxs, index, 1);
                }
            }

        },
        saveComment() {
            if (this.message != null && this.message != ' ') {
                this.errorComment = null;
                this.$http.post('comments', {
                    page_id: this.commentUrl,
                    comment: this.message,
                    users_id: this.user.id
                }).then(res => {

                    if (res.data.status) {
                        this.commentsData.push({ "commentid": res.data.commentId, "name": this.user.name, "comment": this.message, "votes": 0, "reply": 0, "replies": [] });
                        this.message = null;
                    }

                });
            } else {
                this.errorComment = "Please enter a comment to save";
            }
        },
        replyComment(commentId, index) {
            if (this.message != null && this.message != ' ') {
                this.errorReply = null;
                this.$http.post('comments', {
                    comment: this.message,
                    users_id: this.user.id,
                    reply_id: commentId,
                    page_id: this.commentUrl
                }).then(res => {

                    if (res.data.status) {
                        if (!this.commentsData[index].reply) {
                            this.commentsData[index].replies.push({ "commentid": res.data.commentId, "name": this.user.name, "comment": this.message, "votes": 0 });
                            this.commentsData[index].reply = 1;
                            Vue.set(this.replyCommentBoxs, index, 0);
                            Vue.set(this.commentBoxs, index, 0);
                        } else {
                            this.commentsData[index].replies.push({ "commentid": res.data.commentId, "name": this.user.name, "comment": this.message, "votes": 0 });
                            Vue.set(this.replyCommentBoxs, index, 0);
                            Vue.set(this.commentBoxs, index, 0);
                        }
                        this.message = null;
                    }

                });
            } else {
                this.errorReply = "Please enter a comment to save";
            }
        },
        voteComment(commentId, commentType, index, index2, voteType) {
            if (this.user) {
                this.$http.post('comments/' + commentId + '/vote', {
                    users_id: this.user.id,
                    vote: voteType
                }).then(res => {

                    if (res.data) {
                        if (commentType == 'directcomment') {
                            if (voteType == 'up') {
                                this.commentsData[index].votes++;
                            } else if (voteType == 'down') {
                                this.commentsData[index].votes--;
                            }
                        } else if (commentType == 'replycomment') {
                            if (voteType == 'up') {
                                this.commentsData[index].replies[index2].votes++;
                            } else if (voteType == 'down') {
                                this.commentsData[index].replies[index2].votes--;
                            }
                        }
                    }

                });
            }

        },
        spamComment(commentId, commentType, index, index2) {
            console.log("spam here");
            if (this.user) {

                this.$http.post('comments/' + commentId + '/spam', {
                    users_id: this.user.id,
                }).then(res => {
                    if (commentType == 'directcomment') {
                        Vue.set(this.spamComments, index, 1);
                        Vue.set(this.viewcomment, index, 1);
                    } else if (commentType == 'replycomment') {
                        Vue.set(this.spamCommentsReply, index2, 1);
                    }
                });

            }

        },
    },
    mounted() {
       console.log("mounted");
       this.fetchComments();
    }

}
</script>