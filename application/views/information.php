<div class="container main-view col-md-8 col-md-offset-2">
<div class="row">

<h4 class="well">How To Use ODFRMS SMS Service To Query And Update</h4>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#cow" href="#collapseOne">
          Updating Milk record Using the Sms
        </a>
      </h4>
    </div>
    <div class="background-home">
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
      <dl class="bg-info">
        <dt>SMS Format for Milk record Update</dt>
        <dd>
          <em>
            U MILK M=? E=? COW_ID DATE/_
            <ul>
              <li>U- For Update </li>
              <li>MILK- for MILK RECORD</li>
              <li>M/Morning= indicating the amount of morning amount in litres</li>
              <li>E/Evening= indicating the amount of evening amount in litres</li>
              <li>Indicate the cow Id as registered in the system</li>
              <li>You can indicate date in the is Format YYYY-MM-DD or you can leave it blank for 
              the day's milk </li>
              <span class='text-danger'><b>NOTE: Not Case Sensitive</b></span>
            </ul>
          </em>
          <dt>Example</dt>
          <dd> <em><strong>U Milk m=10 e=8 BA001</strong></em> <br>
          Date not Indicated, Assumes It is that day<br>
          </dd>
          <dd> <em><strong>U Milk m=10 e=8 BA001 2014-02-2</strong></em> <br>
          Updates the record with the specified date<br>
          </dd>
        </dd>

      </dl>
        
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#cow" href="#collapseTwo">
          Update Financial Records
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
       
       <dl class="bg-info">
        <dt>SMS Format for Income/Expense Update</dt>
        <dd>
          <em>
            U INCOME/EXPENSE AMOUNT DESCRIPTION DATE/?
            <ul>
              <li>U- For Update </li>
              <li>INCOME/EXPENSE- for either Income or Expense</li>
              <li>AMOUNT- Amount in Kenya Shillings</li>
              <li>DESCRIPTION- In One word Only Or use Underscore</li>
              <li>You can indicate date in the is Format YYYY-MM-DD or you can leave it blank for 
              the day's income or expense</li>
              <span class='text-danger'><b>NOTE: Not Case Sensitive</b></span>
            </ul>
          </em>
        </dd>

         <dt>Example</dt>
          <dd> <em><strong>U expense 737 Drugs_bought</strong></em> <br>
          Date not Indicated, Assumes It is that day<br>
          </dd>
          <dd> <em><strong>U income 887 milk_sold 2014-3-23</strong></em> <br>
          Updates the record with the specified date, Date format YYYY-MM-DD<br>
          </dd>
        </dd>

      </dl>

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#cow" href="#collapseThree">
          Adding a Reminder
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">

      <dl class="bg-info">
        <dt>SMS Format to add reminder</dt>
        <dd>
          <em>
            U REMINDER DATE_OF_ACTIVITY ACTIVITY DESCRIPTION
            <ul>
              <li>U-For Update </li>
              <li>Reminder- for reminder record</li>
              <li>DATE_OF_ACTIVITY- The date of the activity, Date Format: YYYY-MM-DD</li>
              <li>ACTIVITY- In One word Only Or use Underscores</li>
              <li>DESCRIPTION-The description of the Activity In detail</li>
              <span class='text-danger'><b>NOTE: Not Case Sensitive</b></span>
            </ul>
          </em>
        </dd>

         <dt>Example</dt>
          <dd> <em><strong>U Reminder 2014-7-12 Dipping_cattle Cows to be dipped at Makutano Dip </strong></em> <br>
          Date of the activity should be greater than today.<br>
          </dd>
        </dl>

      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#cow" href="#collapseFour">
          Query Milk Record
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">

      <dl class="bg-info">
        <dt>SMS Format to Query Milk Record</dt>
        <dd>
          <em>
            Q MILK TOTAL/AVERAGE DATE/MONTHLY/WEEKLY/WEEK=? COW_ID/ALL
            <ul>
              <li>Q-For Query </li>
              <li>MILK- for Milk record</li>
              <li>TOTAL/AVERAGE-For Total or Average</li>
              <li>DATE/MONTHLY/WEEKLY/DAILY/WEEK=?- Specify Date[YYYY-MM-DD] or Week=?,from today downwards</li>
              <li>COW_ID/ALL- blank for all, or can indicate all cows or Specific Cow_ID</li>
              <li><b>To Get Cow Ids send, 'cows'</b></li>
              <span class='text-danger'><b>NOTE: Not Case Sensitive</b></span>
            </ul>
          </em>
        </dd>

         <dt>Example</dt>
          <dd> <em><strong>Q Milk total week=6 all </strong></em> <br>
          Date of the activity should be greater than today.<br>
          </dd>
          <dd>
            <em><strong>Q Milk average monthly BA001" </strong></em> <br>
          Date of the activity should be greater than today.<br>
          </dd>
        </dl>

      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#cow" href="#collapseFive">
          Query Finance Record
        </a>
      </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse">
      <div class="panel-body">

      <dl class="bg-info">
        <dt>SMS Format to Query Income/Expense Record</dt>
        <dd>
          <em>
            q income/expense, monthly/daily/weekly/week=?/date
            <br>
            q all daily/weekly/monthly/week=?/date

            <ul>
              <li>Q-For Query </li>
              <li>all- For all the Both the Income and Expense and show profit</li>
              <li>INCOME/EXPENSE- for income/Expense record</li>
              <li>TOTAL/AVERAGE-For Total or Average</li>
              <li>DATE/MONTHLY/WEEKLY/DAILY/WEEK=?- Specify Date[YYYY-MM-DD] or Week=?,from today downwards</li>
              <span class='text-danger'><b>NOTE: Not Case Sensitive</b></span>
            </ul>
          </em>
        </dd>

         <dt>Example</dt>
          <dd> <em><strong>Q income  week=6</strong></em> <br>
         
          </dd>
          <dd>
            <em><strong>Q all weekly" </strong></em> <br>
         
          </dd>
        </dl>

      </div>
    </div>
  </div>
  </div>




</div>
</div>
</div>