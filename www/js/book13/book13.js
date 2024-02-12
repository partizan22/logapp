var Delays = {
        base:  1000,
        symb: 300,
        next_art:  1000,
        skip: 1000,
        next_line:  0,
        skip_line: 0,
        speed: 1
};

var Player = {
        row: 0,
        col: -2,
        type: 2,
        active: false,
        tm: false,

        moveto: function(r, c){
                this.stop();
                this.row = r;
                this.c = c;
                this.render({
                        new_art: false,
                        new_row: true,
                        skip: 0,
                        finish: false,
                        size: 0
                });
        },

        toggle: function(){
                if (this.active)
                {
                        this.stop();
                }
                else
                {
                        this.start();
                }
        },

        start: function(){
                this.active = true;
                this.run();
        },

        stop: function(){

                this.active = false;
                Speaker.clear();
                if (this.tm)
                {
                        clearTimeout(this.tm);
                        this.tm = false;
                }
        },

        run: function(){
                if (!this.active)
                {
                        return;
                }

                if (!Speaker.ready)
                {
                        this.tm = setTimeout(function(){
                                Player.run();
                        }, 100);
                        return;
                }

                var mv = this.move(1);

                if (mv.finish)
                {
                        return;
                }

                var delay = Delays.base + Delays.symb * mv.size;
                if (mv.new_art)
                {
                        delay += Delays.next_art;
                }
                if (mv.skip)
                {
                        delay += Delays.skip;
                }

                if (mv.new_row)
                {
                        delay += Delays.next_line;
                }
                if (mv.skip_row)
                {
                        delay += Delays.skip_line;
                }

                delay /= Delays.speed;

                console.log('Delay ' + delay);

                this.tm = setTimeout(function(){
                        Player.run();
                }, delay);
        },

        _move: function(d){
                var result = {
                        new_art: false,
                        new_row: false,
                        skip: 0,
                        finish: false,
                        size: 0
                };

                if (d == -1)
                {
                        if (this.col === -1)
                        {
                                if (this.row == 0)
                                {
                                        result.finish = true;
                                        return result;
                                }

                                this.col = art_count - 1;
                                this.row --;
                                result.new_row = true;

                                this.type == 2;
                        }
                        else if ((this.type  < 2) || (data[this.row][this.col] === false))
                        {
//					if ((this.col < 0)&&(this.row == 0))
//					{
//						result.finish = true;
//						return result;
//					}

                                result.new_art = true;

                                this.col --;
                                //if (this.col < -1)
//					//if (this.col > 5)
//					{
//						this.col = art_count - 1;
//						this.row --;
//						result.new_row = true;
//					}

                                this.type = 2;
                                result.size =  this.col >= 0 ? strlen(data[this.row][this.col].total) : 1;
                        }
                        else
                        {
                                if ((this.col>=0) && (data[this.row][this.col] !== false))
                                {
                                        this.type = data[this.row][this.col].type == 'inc' ? 0 : 1;
                                        result.size = strlen(data[this.row][this.col].val);
                                }
                                else
                                {
                                        this.type = 2;
                                }
                        }
                }
                else
                {
                        if ((this.col>=0)&&(this.type  < 2))
                        {
                                this.type = 2;
                                result.size = strlen(data[this.row][this.col].total);
                        }
                        else
                        {
                                if ((this.col+1 == art_count)&&(this.row+1 == rows_count))
                                {
                                        result.finish = true;
                                        return result;
                                }

                                result.new_art = true;

                                this.col ++;
                                if (this.col == art_count)
                                //if (this.col > 5)
                                {
                                        this.col = -1;
                                        this.row ++;
                                        result.new_row = true;
                                }

                                if ((this.col>=0) && (data[this.row][this.col] !== false))
                                {
                                        this.type = data[this.row][this.col].type == 'inc' ? 0 : 1;
                                        result.size = strlen(data[this.row][this.col].val);
                                }
                        }
                }


                console.log(this.row, this.col, this.type);


                if ((this.col>=0)&&(data[this.row][this.col] === false))
                {
                        var c_r = this.row;
                        var r_new = this._move(d);

                        result.new_art = true;
                        result.skip =  (c_r == this.row) ?  r_new.skip+1 : r_new.skip;
                        result.new_row = result.new_row || r_new.new_row;
                        result.finish = r_new.finish;
                        result.size = r_new.size;
                }

                return result;
        },



        move: function(d){

                Speaker.clear();

                var r = this.row;
                var mv = this._move(d);

                if (Math.abs(this.row - r) > 1)
                {
                        r.skip_row = Math.abs(this.row - r) - 1;
                }

                this.render(mv);

                return mv;
        },

        render: function(mv){

                $('.skip').css({display: 'none'});

                $('.act-row').removeClass('act-head');
                $('.act-row').removeClass('act-row');
                $('.act-col').removeClass('act-col');
                $('.act-t').removeClass('act-t');

                $('.row-' + this.row).addClass('act-row');
                $('.art-' + this.col).addClass('act-col');

                $('.t-' + this.type).addClass('act-t');

                if (this.col == -1)
                {
                        $('.act-row').addClass('act-head');
                }

                var W = $('.table-body').width();
                var p = (this.col==-1) ? $('tr.act-row td.art-0').position()  :  $('tr.act-row td.act-col.t-0').position();
                var c = (W - 3*D) * 0.45;

                var left = p.left - c;

                if (left < 0)
                {
                        left = 0;
                }

                var H = $('.table-body').height();
                c = (c-40) * 0.50;
                var top = p.top - c;

                if (top < 0)
                {
                        top = 0;
                }

                if ((this.col>=0)&&(mv.skip))
                {
                        var l1 = $( ".table-body" ).scrollLeft();
                        var t1 = $( ".table-body" ).scrollTop();

                        var o = $('tr.act-row td.act-col.t-0').offset();

                        $('.skip-cnt').html('col-' + mv.skip);
                        $('.skip').css({  display: '', top:  o.top /* - t1 + top */, left: o.left - 3*D  });
                        $('.skip').animate({left: o.left - 3*D + l1 - left}, 300, 'swing');
                }
//			else if (mv.skip_row)
//			{
//				var l1 = $( ".table-body" ).scrollLeft();
//				var t1 = $( ".table-body" ).scrollTop();
//				var h = $('tr.act-row td.act-col.t-0').height();
//				
//				var o = $('tr.act-row td.act-col.t-0').offset();
//				
//				$('.skip-cnt').html('row-' + mv.skip_row);
//				$('.skip').css({  display: '', top:  o.top - h, left: o.left - 3*D  });
//				$('.skip').animate({top: o.top - h + t1 - top}, 50, 'swing');
//			}

                //if (left != 0)
                {
                        $( ".table-body" ).animate({scrollLeft: left}, (mv.skip)  ? 300 :  150, 'swing');
                }

                //if (top != 0)
                {
                        $( ".table-body" ).animate({scrollTop: top}, 50, 'swing');
                }

                if (/*(this.col >= 0) && */this.active && !mv.finish )
                {
                        this.speak(mv);
                }

        },

        speak: function(mv){

                if (this.col === -1)
                {

                        var doc = documents[this.row];
                        if (doc.type === 'ttn')
                        {
                                Speaker.add('ttn');
                        }
                        else
                        {
                                Speaker.add('nakl');
                        }

                        if (! ((doc.type === 'ttn') && (doc.empty) ) )
                        {
                                Speaker.add_doc_number(doc.number, doc.empty);
                        }

                        if (doc.empty)
                        {
                                Speaker.add('empty');
                        }

                        return;
                }

                if ( mv.new_art)
                {
                        if (mv.skip)
                        {
                                Speaker.add('skip');
                        }

                        Speaker.addart(articles[this.col], mv.skip ? 1500 : 200);

//				var a = articles[this.col];
//				Speaker.add('art');
//				
//				Speaker.addt(6, a.substring(0, 2));
//				var p2 = a.substring(2, 4);
//				if (p2.charAt(0) == '0')
//				{
//					Speaker.addlz(p2, mv.skip ? 1500 : 200)
//				}
//				else
//				{
//					Speaker.addn(p2,  mv.skip ? 1500 : 200);
//				}

                }

                if (this.type < 2)
                {
                        Speaker.add( this.type == 0 ? 'input' : 'output' );
                }
                else
                {
                        Speaker.add( 'become' );
                }

                var val = this.type==2 ? data[this.row][this.col].total : data[this.row][this.col].val;

                Speaker.add_number(val);

                Speaker.delay(250);
        }


};
	
function strlen(v)
{
        var s = "" + v + "";
        return s.length;
}

var Speaker = {
		
        current: false,
        current_play: false,
        q: [],
        ready: true,
        rate: 1.0,

        _run: function(){

                if ( this.current && !this.current.ended)
                {
                        setTimeout(function(){ Speaker._run(); }, 1);
                        return;
                }

                this.current = false;

                if (!this.q.length)
                {
                        this.ready = true;
                        return;
                }

                this.ready = false;
                var current_rate = this.q[0][2] ? this.q[0][2] : 1.0 ;

                if (this.q[0][0] == '0')
                {
                        this.current = audio[ this.q[0][1] ];
                        this.current_play = this.current;
                        this.current_play.playbackRate = current_rate;
                        this.current.play();
                        setTimeout(function(){ Speaker._run(); }, 1);
                }
                else if (this.q[0][0] == '2')
                {
                        audio.main.currentTime = 3 * this.q[0][1];
                        this.current_play = audio.main;
                        this.current_play.playbackRate = current_rate;
                        audio.main.play();
                        window.setTimeout(function(){ audio.main.pause();  Speaker._run(); }, (durations["" + this.q[0][1] ] )  / current_rate - 150 );
                }
                else if (this.q[0][0] == '6')
                {
                        audio.main.currentTime = 3 * this.q[0][1];
                        this.current_play = audio.main;
                        this.current_play.playbackRate = current_rate;
                        audio.main.play();
                        window.setTimeout(function(){ audio.main.pause();  Speaker._run(); }, (durations["" + this.q[0][1] ]  - 200) / current_rate );
                }
                else if (this.q[0][0] == '7')
                {
                        audio.arts.currentTime = 3 * full_arts.indexOf(this.q[0][1]);
                        this.current_play = audio.arts;
                        this.current_play.playbackRate = current_rate;
                        audio.arts.play();
                        window.setTimeout(function(){ audio.arts.pause();  Speaker._run(); }, durations["art" + this.q[0][1] ] / current_rate );
                }
                else if (this.q[0][0] == '3')
                {
                        audio.sf.currentTime = 3 * (this.q[0][1]-1);
                        this.current_play = audio.sf;
                        this.current_play.playbackRate = current_rate;
                        audio.sf.play();
                        window.setTimeout(function(){ audio.sf.pause();  Speaker._run(); }, durations[ this.q[0][1] + "sf" ] / current_rate );
                }
                else if (this.q[0][0] == '4')
                {
                        audio.lz.currentTime = 3 * (this.q[0][1]-1);
                        this.current_play = audio.lz;
                        this.current_play.playbackRate = current_rate;
                        audio.lz.play();
                        window.setTimeout(function(){ audio.lz.pause();  Speaker._run(); }, durations[ this.q[0][1] + "lz" ] / current_rate );
                }
                else if (this.q[0][0] == '5')
                {
                        audio.lz1.currentTime = 3 * (this.q[0][1]-1);
                        this.current_play = audio.lz1;
                        this.current_play.playbackRate = current_rate;
                        audio.lz1.play();
                        window.setTimeout(function(){ audio.lz1.pause();  Speaker._run(); }, durations[ this.q[0][1] + "lz1" ] / current_rate  );
                }
                else
                {
                        window.setTimeout(function(){ Speaker._run(); }, this.q[0][1]);
                }

                this.q = this.q.slice(1);

        },

        add: function(text, delay){

                if (!delay)
                {
                        delay = 0;
                }

                this.q.push([0, text, this.rate]);

                if (delay)
                {
                        this.delay(delay);
                }

                if (this.ready)
                {
                        this._run();
                }
        },

        addt: function(t, text, delay){

                if (!delay)
                {
                        delay = 0;
                }

                this.q.push([t, text, this.rate]);

                if (delay)
                {
                        this.delay(delay);
                }

                if (this.ready)
                {
                        this._run();
                }
        },

        addn: function(n, delay){
                this.addt(2, ""+n, delay);
        },

        adds: function(n, delay)
        {
                this.addt(3, ""+n, delay);
        },

        addlz: function(st, delay)
        {
                console.log("add lz", st);
                var i = parseInt(st);
                if (st.charAt(0) != '0')
                {
                        console.log("addn", i);
                        return this.addn(i, delay);
                }
                if (st.length == 2)
                {
                        console.log("addt5", i);
                        return this.addt(5, i, delay);
                }
                console.log("addt4", i);
                return this.addt(4, i, delay);
        },

        addart(a, delay){
                console.log(a);
                this.addt(7, a, delay);
        },

        delay: function(d){
                this.q.push([1, d]);
        },

        add_number: function(st){

                var ii = st.split(',');
                var ss = ii[0].split(' ');

                if (ss.length == 2)
                {
                        this.adds(parseInt(ss[0]));
                        ss = ss[1];
                }

                this.addn(parseInt(ss));

                if (parseInt(ii[1]) === 0)
                {
                        this.add('int');
                }
                else
                {
                        this.add('coma');
                        this.addlz(ii[1]);
                }
        },

        add_doc_number : function(number, empty) {

                this.rate = empty ? 2 : 1.5;
                if (number.length > 3)
                {
                        var s = number.replace(/[^0-9]/g, '');
                        var parts = [];
                        if (s.length % 3 == 1)
                        {
                                parts.push(s.slice(0, 2));
                                parts.push(s.slice(2, 4));
                                s = s.slice(4);
                        }
                        else if (s.length % 3 == 2)
                        {
                                parts.push(s.slice(0, 2));
                                s = s.slice(2);
                        }
                        while (s > '')
                        {
                                parts.push(s.slice(0, 3));
                                s = s.slice(3);
                        }

                        console.log(parts);

                        for (var i of parts)
                        {
                                Speaker.addlz(i);
                        }

                }
                else
                {
                        this.addn(parseInt(number));
                }
                this.rate = 1.0;
        },

        clear: function(){
                this.q = [];
        }

};