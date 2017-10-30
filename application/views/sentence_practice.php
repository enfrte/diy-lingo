<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container">

  <div id="instance">

    <h3>{{ question }}</h3>

      <div id="answer_area" class="text-area">
        <button class="word-button" v-for="text in choices" v-on:click="remove(text)">
          {{ text }}
        </button>
      </div>

      <div id="stage_area" class="text-area">
        <button class="word-button" style="background-color:snow;" v-for="text in staged" v-on:click="choose(text)">
          {{ text }}
        </button>
      </div>

      <button class="answer-button" style="width:100%;" v-on:click="checkAnswer()">Check Answer</button>

        <h4 style="float:left;">Question {{ currentQuestionNumber }} of {{ numberOfQuestions }}</h4>
        <h4 style="float:right;">Score {{ scorePercentage }}%</h4>

      <div class="progressbar-container">
        <span v-bind:style="{ width: progressPercentage + '%' }" class="question-progressbar">{{ progressPercentage }}%</span>
      </div>

      <!-- game over pop up 
      <button id="show-modal" @click="showModal = true">Show Modal</button>
      -->
      <modal v-if="showModal" @close="redirectBack">
        <!--
          you can use custom content here to overwrite
          default content
        -->
        <h3 slot="header">Practice complete</h3>
      </modal>

  </div>

</div>

<script src="<?php echo base_url('assets/vue.js'); ?>"></script>
<!-- <script src="axios.min.js"></script> -->
<script src="<?php echo base_url('assets/jquery.js'); ?>"></script>

<script>

var serverData = {
  questions: <?php echo $practice_sentences; ?> // [source_translation, translated_answer, staged_answer]
};

// Note: xss cleaning is done at the model 
var vm = new Vue({
  el: '#instance',
  computed: {
    answer() {
      return this.choices.join(' ');
    },
    question() {
      if( this.questionNumber < serverData.questions.length ){
        return serverData.questions[this.questionNumber][0];
      } else {
        // recall the final question in place, instead of removing it
        return serverData.questions[serverData.questions.length - 1][0];
      }
    },
    staged() {
      if( this.questionNumber < serverData.questions.length ){
        return serverData.questions[this.questionNumber][2];
      } else {
        // recall the final staged question in place, instead of removing it
        return serverData.questions[serverData.questions.length - 1][2];
      }
    },
    scorePercentage() {
      if(this.questionNumber === 0) {
        return 0; // cannot divide by zero!
      }
      else {
        return Math.floor((this.score / this.questionNumber) * 100);
      }
    },
    progressPercentage() {
      return  Math.floor(((this.questionNumber) / (serverData.questions.length)) * 100);
    },
    currentQuestionNumber() {
      if( this.questionNumber < serverData.questions.length ){
        return this.questionNumber + 1;
      } else {
        return this.questionNumber;
      }
    },

  },
  data: {
    questionNumber: 0,
    score: 0,
    choices: [],
    numberOfQuestions: serverData.questions.length,
    showModal: false,
  },
  methods: {
    choose(text) {
      this.staged.splice(this.staged.indexOf(text), 1)
      this.choices.push(text)
    },
    remove(text) {
      this.choices.splice(this.choices.indexOf(text), 1)
      this.staged.push(text)
    },
    checkAnswer(){
      if( this.questionNumber < serverData.questions.length ){
        if(this.answer === serverData.questions[this.questionNumber][1]){
          console.log(this.questionNumber + " is correct");
          this.score++;
        }
        else {
          console.log(this.questionNumber + " is wrong");
        }
        this.questionNumber++;
        if( this.questionNumber < serverData.questions.length ){
          // this conditional keeps the final answer in view instead of removing it
          this.choices = [];
          console.log('foo ' + this.questionNumber + ' / ' + serverData.questions.length);
        }
      }
      
      if (this.questionNumber === serverData.questions.length) {
        setTimeout(function(){
          vm.showModal = true; // display game over popup
        }, 1000);
      }
    },
    redirectBack(){
      // return the user to the previous page
      window.location.replace("<?php echo $_SERVER['HTTP_REFERER']; ?>");
    },
  }
});

var app = {
  //serverData: <?php echo $practice_sentences; ?>,
  // pass selected answer to hidden input
  setAnswer: function(){
    document.getElementById('answer').value = vm.answer;
  },
  verticallyCenterArea: function(){
    var instanceHeight = document.getElementById('instance').clientHeight + 100; // 15 is margin of container
    var windowHeight = window.innerHeight;
    if ( (instanceHeight + 100) <= windowHeight ) {
      verticalDrop = (windowHeight - instanceHeight) / 3;
      document.getElementById("container").style.transform = "translateY(" + verticalDrop + "px)";
    }
  }
};
app.verticallyCenterArea();

// gameover popup
Vue.component('modal', {
  template: '#modal-template'
})

</script>


<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              <!-- default header text -->
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              <!-- default body text -->
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <!-- default footer text -->
              <button class="answer-button" style="width:100%;" v-on:click="$emit('close')">Finish</button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>
