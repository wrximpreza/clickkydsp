<?php $this->layout('app:layout');?>

<div class="container">

    <div class="row">
        <div class="col-md-2">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-left">
                <li class="active"><a href="#DSP" data-toggle="tab">DSP</a></li>
                <li><a href="#SSP" data-toggle="tab">SSP</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div class="row">
                    <form action="/web/" id="sendForm">
                        <div class="col-md-3" style="line-height: 45px;">DSP STATS</div>
                        <div class="col-md-5">

                            <div class="form-inline" <?php if(isset($_GET['date'])) if($_GET['date']!=5) echo 'style="display: none;"'; ?>>
                                <div class="form-group">
                                    <input type="text" id="datetimepicker_1" value="<?php if(isset($_GET['from'])) echo $_GET['from']; ?>" name="from" class="form-control"  placeholder="Date from">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="datetimepicker_2" value="<?php if(isset($_GET['to'])) echo $_GET['to']; ?>" name="to" class="form-control"  placeholder="Date to">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 date">
                            <span style="float: left;">Date</span>

                            <select  name="date" id="date" class="form-control">
                                <option value="1">Today</option>
                                <option value="2" <?php if(isset($_GET['date'])) if($_GET['date']==2) echo 'selected';?>>Yesterday</option>
                                <option value="3" <?php if(isset($_GET['date'])) if($_GET['date']==3) echo 'selected';?>>For week</option>
                                <option value="4" <?php if(isset($_GET['date'])) if($_GET['date']==4) echo 'selected';?>>For month</option>
                                <option value="5" <?php if(isset($_GET['date'])) if($_GET['date']==5) echo 'selected';?>>From date to date</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" onclick="$('#preloader').show();"  class="btn btn-primary">GET</button>
                        </div>
                    </form>
                </div>
                <hr />
                <div class="tab-pane active" id="DSP">

                    <?php if(count($dsps)>0): ?>
                        <table id="dataTable" class="display">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DSP</th>
                                <th>Date</th>
                                <th>Revenue</th>
                                <th>Impression</th>
                                <th>Responses</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach($dsps as $k=>$dsp):
                                    if($k!='total') {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $k; ?></td>
                                            <td><?php echo $dsp['selected_date']; ?></td>
                                            <td><?php echo $dsp['revenue']; ?></td>
                                            <td><?php echo $dsp['impressions']; ?></td>
                                            <td><?php echo $dsp['responses']; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                            endforeach; ?>
                            <tfoot>
                            <tr>
                                <td>TOTAL</td>
                                <td></td>
                                <td></td>
                                <td><?php echo $dsps['total']['revenue']; ?></td>
                                <td><?php echo $dsps['total']['impressions']; ?></td>
                                <td><?php echo $dsps['total']['responses']; ?></td>
                            </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-error" role="alert">
                            No data or error load page
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane" id="SSP">
                    <?php if(count($ssps)>0): ?>
                        <table id="dataTable_ssp" class="display">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DSP</th>
                                <th>Date</th>
                                <th>Revenue</th>
                                <th>Impression</th>
                                <th>Responses</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach($ssps as $k=>$ssp):
                                if($k!='total') {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $k; ?></td>
                                        <td><?php echo $ssp['selected_date']; ?></td>
                                        <td><?php echo $ssp['revenue']; ?></td>
                                        <td><?php echo $ssp['impressions']; ?></td>
                                        <td><?php echo $ssp['responses']; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            endforeach; ?>
                            <tfoot>
                            <tr>
                                <td>TOTAL</td>
                                <td></td>
                                <td></td>
                                <td><?php echo $ssps['total']['revenue']; ?></td>
                                <td><?php echo $ssps['total']['impressions']; ?></td>
                                <td><?php echo $ssps['total']['responses']; ?></td>
                            </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-error" role="alert">
                            No data or error load page
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
