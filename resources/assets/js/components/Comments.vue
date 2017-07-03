<template>
<style>

.text-right{ text-align: right; }

.comments-app{
  margin: 50px auto;
  max-width: 680px;
  padding: 0 50px;
  width: 100%;
}

.comments-app h1{
  color: #191919;
  margin-bottom: 1.5em;
  text-align: center;
  text-shadow: 0 0 2px rgba(152, 152, 152, 1);
}

.comment-form{  }
.comment-form .comment-avatar{  }
.comment-v{
  margin-top : 5px;
}
.comment-form .form{ margin-left: 100px; }

.comment-form .form .form-row{ margin-bottom: 10px; }
.comment-form .form .form-row:last-child{ margin-bottom: 0; }

.comment-form .form .input{
  background-color: #fcfcfc;
  border: none;
  border-radius: 4px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .15);
  color: #555f77;
  font-family: inherit;
  font-size: 14px;
  padding: 5px 10px;
  outline: none;
  width: 100%;

  -webkit-transition: 350ms box-shadow;
  -moz-transition: 350ms box-shadow;
  -ms-transition: 350ms box-shadow;
  -o-transition: 350ms box-shadow;
  transition: 350ms box-shadow;
}

.comment-form .form textarea.input{
  height: 100px;
  padding: 15px;
}

.comment-form .form label{
  color: #555f77;
  font-family: inherit;
  font-size: 14px;
}

.comment-form .form input[type=submit]{
  background-color: #555f77;
  border: none;
  border-radius: 4px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .15);
  color: #fff;
  cursor: pointer;
  display: block;
  margin-left: auto;
  outline: none;
  padding: 6px 15px;

  -webkit-transition: 350ms box-shadow;
  -moz-transition: 350ms box-shadow;
  -ms-transition: 350ms box-shadow;
  -o-transition: 350ms box-shadow;
  transition: 350ms box-shadow;
}

.comment-form .form .input:focus,
.comment-form .form input[type=submit]:focus,
.comment-form .form input[type=submit]:hover{
  box-shadow: 0 2px 6px rgba(121, 137, 148, .55);
}

.comment-form .form.ng-submitted .input.ng-invalid,
.comment-form .form .input.ng-dirty.ng-invalid{
  box-shadow: 0 2px 6px rgba(212, 47, 47, .55) !important;
}

.comment-form .form .input.disabled {
    background-color: #E8E8E8;
}


.comments{  }

.comment-form,
.comment{
  margin-bottom: 20px;
  position: relative;
  z-index: 0;
}

.comment-form .comment-avatar,
.comment .comment-avatar{
  border: 2px solid #fff;
  border-radius: 50%;
  box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
  height: 80px;
  left: 0;
  overflow: hidden;
  position: absolute;
  top: 0;
  width: 80px;
}

.comment-form .comment-avatar img,
.comment .comment-avatar img{
  display: block;
  height: auto;
  width: 100%;
}

.comment .comment-box{
  background-color: #fcfcfc;
  border-radius: 4px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .15);
  margin-left: 100px;
  min-height: 60px;
  position: relative;
  padding: 15px;
}

.comment .comment-box:before,
.comment .comment-box:after{
  border-width: 10px 10px 10px 0;
  border-style: solid;
  border-color: transparent #FCFCFC;
  content: "";
  left: -10px;
  position: absolute;
  top: 20px;
}

.comment .comment-box:before{
  border-color: transparent rgba(0, 0, 0, .05);
   top: 22px;
}

.comment .comment-text{
  color: #555f77;
  font-size: 15px;
  margin-bottom: 25px;
}

.comment .comment-footer{
  color: #acb4c2;
  font-size: 13px;
}

.comment .comment-footer:after{
  content: "";
  display: table;
  clear: both;
}

.comment .comment-footer a{
  color: #acb4c2;
  text-decoration: none;

  -webkit-transition: 350ms color;
  -moz-transition: 350ms color;
  -ms-transition: 350ms color;
  -o-transition: 350ms color;
  transition: 350ms color;
}

.comment .comment-footer a:hover{
  color: #555f77;
  text-decoration: underline;
}

.comment .comment-info{
  float: left;
  width: 85%;
}

.comment .comment-author{ }
.comment .comment-date{ }

.comment .comment-date:before{
  content: "|";
  margin: 0 10px;
}

.comment-actions{
  float: left;
  text-align: right;
  width: 15%;
}

.reply{
    margin-top: 5px;
    margin-left: 60px;
}
.list{
    list-style: none;
    list-style-type: none;
    display: inline !important;
}
</style>

<div class="comments-app">
    <h1>Comments App - AngularJS</h1>

    <!-- From -->
    <div class="comment-form" v-if="user">
        <!-- Comment Avatar -->
        <div class="comment-avatar">
            <img src="{{user.photo_url}}">
        </div>

        <form class="form" name="form">
            <div class="form-row">
                <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                <span class="input" v-if="errorComment" style="color:red">{{errorComment}}</span>
            </div>

            <div class="form-row">
                <input class="input" placeholder="Email" type="text" value="{{ user.name}}">
            </div>

            <div class="form-row">
                <input type="button" @click="saveComment" value="Add Comment">
            </div>
        </form>
    </div>
    <div class="comment-form" v-else>
        <!-- Comment Avatar -->
        <div class="comment-avatar">
            <img src="{{user.photo_url}}">
        </div>
        <form class="form" name="form">
            <div class="form-row">
                <a href="login"><textarea
                  class="input"
                  placeholder="Add comment..."
                  required></textarea></a>
            </div>
        </form>
    </div>
    <!-- Comments List -->
    <div class="comments" v-if="comments" v-for="(index , comment) in commentsData">
        <!-- Comment -->
        <div v-if="!spamComments[index] || !comment.spam" class="comment">
            <!-- Comment Avatar -->
            <div class="comment-avatar">
                <img ng-src="{{comment.photo_url}}">
            </div>

            <!-- Comment Box -->
            <div class="comment-box">
                <div class="comment-text">{{comment.comment}}</div>
                <div class="comment-footer">
                    <div class="comment-info">
                        <span class="comment-author">
              <em>{{ comment.name}} {{comment.reply}}</em>
            </span>
                        <span class="comment-date">10-5-6</span>
                    </div>

                    <div class="comment-actions">
                        <ul class="list">
                            <li>Votes: {{comment.votes}} <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'up')">Up Votes</a> <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'down')">Down Votes</a></li>
                            <li><a v-on:click="spamComment(comment.commentId,'directcomment',index,0)">Spam</a></li>
                            <li><a v-on:click="openComment(index)">Reply</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- From -->
            <div class="comment-form comment-v" v-if="commentBoxs[index]">
                <!-- Comment Avatar -->
                <div class="comment-avatar">
                    <img src="{{user.photo_url}}">
                </div>

                <form class="form" name="form">
                    <div class="form-row">
                        <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                        <span class="input" v-if="errorReply" v-model="" style="color:red">{{errorReply}}</span>
                    </div>

                    <div class="form-row">
                        <input class="input" placeholder="Email" type="text" value="{{user.name}}">
                    </div>

                    <div class="form-row">
                        <input type="button" v-on:click="replyComment(comment.commentid,index)" value="Add Comment">
                    </div>
                </form>
            </div>
            <div class="form-row reply" v-if="comment.replies.length > 1">
                <a v-if="viewcomment[index]" @click="showComments(index)">Hide comments {{comment.replies.length - 1}}</a>
                <a v-else @click="showComments(index)">View more {{comment.replies.length - 1}} comments </a>
            </div>
            <!-- Comment - Reply -->
            <div v-if="viewcomment[index]">
                <div class="comments" v-if="comments" v-for="(index2, replies) in comment.replies">
                    <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">

                        <!-- Comment Avatar -->
                        <div class="comment-avatar">
                            <img src="{{replies.photo_url}}">
                        </div>

                        <!-- Comment Box -->
                        <div class="comment-box">
                            <div class="comment-text">{{replies.comment}} {{replies.photo_url}}</div>
                            <div class="comment-footer">
                                <div class="comment-info">
                                    <span class="comment-author">
              {{replies.name}}
            </span>
                                    <span class="comment-date">Feb 2, 2013 11:32:04 PM</span>
                                </div>

                                <div class="comment-actions">
                                    <ul class="list">
                                        <li>Total votes: {{replies.votes}} <a v-if="!replies.votedByUser" v-on:click="voteComment(replies.commentid,'replycomment',index,index2,'up')">Up Votes</a> <a v-if="!replies.votedByUser" v-on:click="voteComment(comment.commentid,'replycomment',index,index2,'down')">Down Votes</a></a></li>
                                        <li><a v-on:click="spamComment(replies.commentid,'replycomment',index,index2)">Spam</a></li>
                                        <li><a v-on:click="replyCommentBox(index2)">Reply</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- From -->
                        <div class="comment-form reply" v-if="replyCommentBoxs[index2]">
                            <!-- Comment Avatar -->
                            <div class="comment-avatar">
                                <img src="{{user.photo_url}}">
                            </div>

                            <form class="form" name="form">
                                <div class="form-row">
                                    <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                                    <span class="input" v-if="errorReply" v-model="" style="color:red">{{errorReply}}</span> 
                                </div>

                                <div class="form-row">
                                    <input class="input" placeholder="Email" type="text" value="{{user.name}}">
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
        <div class="comment reply" v-if="comment.reply == 1 && !viewcomment[index]" && !spamComments[index]>

            <!-- Comment Avatar -->
            <div class="comment-avatar">
                <img src="{{replies.photo_url}}">
            </div>

            <!-- Comment Box -->
            <div class="comment-box">
                <div class="comment-text">{{comment.replies[comment.replies.length-1].comment}}</div>
                <div class="comment-footer">
                    <div class="comment-info">
                        <span class="comment-author">
              {{replies.name}}
            </span>
                        <span class="comment-date">Feb 2, 2013 11:32:04 PM</span>
                    </div>

                    <div class="comment-actions">
                        <ul class="list">
                            <li>Total votes: {{comment.replies[comment.replies.length-1].votes}} <a v-if="!comment.replies[comment.replies.length-1].votedByUser" v-on:click="voteComment(comment.replies[comment.replies.length-1].commentid,'replycomment',index,comment.replies.length-1,'up')">Up Votes</a><a v-if="!comment.replies[comment.replies.length-1].votedByUser" v-on:click="voteComment(comment.replies[comment.replies.length-1].commentid,'replycomment',index,comment.replies.length-1,'down')">Down Votes</a></li>
                            <li><a v-on:click="spamComment(comment.replies[comment.replies.length-1].commentid,'replycomment',index,index2)">Spam</a></li>
                            <li><a v-on:click="replyCommentBox(comment.replies.length-1)">Reply</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- From -->
            <div class="comment-form reply" v-if="user">
                <!-- Comment Avatar -->
                <div class="comment-avatar">
                    <img src="{{user.photo_url}}">
                </div>

                <form class="form" name="form">
                    <div class="form-row">
                        <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                    </div>

                    <div class="form-row">
                        <input class="input" placeholder="Email" type="text" value="{{user.name}}">
                    </div>


                    <div class="form-row">
                        <input type="button" v-on:click="replyComment(comment.commentid,index)" value="Add Comment">
                    </div>
                </form>
            </div>
            <!--End Form-->
        </div>
    </div>
</div>
</template>

<script>
var _ = require('lodash');
 export default {
    props: ['commentUrl','user'],
    data() {
      return {
        comments : [],
        commentreplies : [],
        comments : 0,
        commentBoxs : [],
        message : null,
        replyCommentBoxs : [],
        commentsData : [],
        viewcomment : [],
        show : [],
        spamCommentsReply : [],
        spamComments : [],
        errorComment : null,
        errorReply : null
      }
    },
    computed :{
        /*commentsData(){
          return _.orderBy(this.commentData,'votes','asc');
        }*/
    },
    http: {
        headers: {
            'X-CSRF-TOKEN': window.Spark.csrfToken
        }
    },
    methods: {
      fetchComments(){
          this.$http.get('comments/'+this.commentUrl).then(res => {
              
              this.commentData = res.data;
              this.commentsData = _.orderBy(res.data,['votes'],['desc']);
              console.log(this.commentsData);
              //this.commentsData.sortBy('votes' => asc);
              this.comments = 1;
          });
      },
      showComments(index){
        if(!this.viewcomment[index]){
          Vue.set(this.show, index ,"hide");
          Vue.set(this.viewcomment, index ,1);
        }else{
          Vue.set(this.show, index ,"view");
          Vue.set(this.viewcomment, index ,0);
        }
      },
      openComment(index){
        if(this.user){
          if(this.commentBoxs[index]){
            Vue.set(this.commentBoxs, index ,0);
          }else{
            Vue.set(this.commentBoxs, index ,1);
          }
        }
        
      },
      replyCommentBox(index){
        if(this.user){
          if(this.replyCommentBoxs[index]){
            Vue.set(this.replyCommentBoxs, index ,0);
          }else{
            Vue.set(this.replyCommentBoxs, index ,1);
          }
        }
        
      },
      saveComment(){
        if(this.message != null && this.message != ' '){
            this.errorComment = null;
            this.$http.post('comments',{
            page_id : this.commentUrl,
            comment : this.message,
            users_id : this.user.id
            }).then(res => {
                
                if(res.data.status){
                    this.commentsData.push({"commentid":res.data.commentId,"name" : this.user.name, "comment" : this.message, "votes" : 0 , "reply" : 0, "replies" : [] });
                    this.message = null;
                }

            });
        }else{
            this.errorComment = "Please enter a comment to save";
        }         
      },
      replyComment(commentId,index){
        if(this.message != null && this.message != ' '){
            this.errorReply = null;
            this.$http.post('comments',{
            comment : this.message,
            users_id : this.user.id,
            reply_id : commentId
            }).then(res => {
                
                if(res.data.status){
                    if(!this.commentsData[index].reply){
                        this.commentsData[index].replies.push({"commentid":res.data.commentId,"name" : this.user.name, "comment" : this.message, "votes" : 0 });
                        this.commentsData[index].reply = 1;
                        Vue.set(this.replyCommentBoxs, index ,0);
                        Vue.set(this.commentBoxs, index ,0);
                    }else{
                        this.commentsData[index].replies.push({"commentid":res.data.commentId,"name" : this.user.name, "comment" : this.message, "votes" : 0 });
                        Vue.set(this.replyCommentBoxs, index ,0);
                        Vue.set(this.commentBoxs, index ,0);
                    }
                    this.message = null;
                }

            });
        }else{
            this.errorReply = "Please enter a comment to save";
        }  
      },
      voteComment(commentId,commentType,index,index2,voteType){
        if(this.user){
          this.$http.post('comments/'+commentId+'/vote',{
            users_id : this.user.id,
            vote : voteType
        }).then(res => {
              
              if(res.data){
                if(commentType == 'directcomment'){
                    if(voteType == 'up'){
                    this.commentsData[index].votes++;
                    } else if(voteType == 'down'){
                    this.commentsData[index].votes--;
                    }
                } else if(commentType == 'replycomment'){
                    if(voteType == 'up'){
                    this.commentsData[index].replies[index2].votes++;
                    } else if(voteType == 'down'){
                    this.commentsData[index].replies[index2].votes--;
                    }
                }
              }

          });            
        }
        
      },
      spamComment(commentId,commentType,index,index2){
        console.log("spam here");
        if(this.user){
            
            this.$http.post('comments/'+commentId+'/spam',{
            users_id : this.user.id,
            }).then(res => {
                if(commentType == 'directcomment'){
                    Vue.set(this.spamComments, index ,1);
                    Vue.set(this.viewcomment, index ,1);
                } else if(commentType == 'replycomment'){
                    Vue.set(this.spamCommentsReply, index2 ,1);
                }
            });
        
        }
        
      },
    },
    ready() {
      this.fetchComments();
     
    }

  }
</script>