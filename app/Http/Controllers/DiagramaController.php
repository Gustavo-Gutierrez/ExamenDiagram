<?php

namespace App\Http\Controllers;

use App\Events\DiagramaSent;
use App\Models\Diagrama;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\User_diagrama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiagramaController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        $diagramas = $proyecto->diagramas()->paginate(4);
        return view('diagramas.index', compact('diagramas', 'proyecto'));
    }

    public function misDiagramas()
    {
        $diagramas = Auth::user()->misDiagramas()->paginate(3);
        return view('diagramas.misdiagramas', compact('diagramas'));
    }

    public function diagramar(Diagrama $diagrama)
    {
        $proyecto = $diagrama->proyecto;
        $permiso = Auth::user()->user_diagramas()->where('diagrama_id', $diagrama->id)->first();
        $permiso = $permiso->editar;
        return view('diagramas.diagramar', compact('diagrama', 'proyecto', 'permiso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'descripcion' => ['required'],
            'tipo' => ['required'],
        ]);
        try {
            $diagrama = new Diagrama();
            $diagrama->nombre = $request->nombre;
            $diagrama->descripcion = $request->descripcion;
            $diagrama->tipo = $request->tipo;
            $diagrama->user_id = Auth::user()->id;
            $diagrama->proyecto_id = $request->proyecto_id;
            if ($request->diagrama_id != 'nuevo') {
                $newDiagram = Diagrama::find($request->diagrama_id);
                $diagrama->contenido = $newDiagram->contenido;
            } else {
                $diagrama->contenido = '';
            }
            $diagrama->save();
            DB::table('user_diagramas')->insert([
                'user_id' => $diagrama->user_id,
                'diagrama_id' => $diagrama->id
            ]);
            return redirect()->route('diagramas.index', $request->proyecto_id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    public function editor(Request $request)
    {
        $user = User::find($request->input('id'));
        $relacion = $user->user_diagramas()->where('diagrama_id', $request->input('diagrama'))->first();
        $relacionv = User_diagrama::find($relacion->id);
        $relacionv->editar = $relacionv->editar == 0 ? 1 : 0;
        $relacionv->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
    }

    public function favorito(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->favorito = $diagrama->favorito == 0 ? 1 : 0;
        $diagrama->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
        /* return  redirect()->back()->with('message', 'Se reitro de favoritos '); */
    }

    public function terminado(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->terminado = $diagrama->terminado == 0 ? 1 : 0;
        $diagrama->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
        /* return  redirect()->back()->with('message', 'Se reitro de favoritos '); */
    }

    public function guardar(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->contenido = $request->input('contenido');
        $diagrama->update();
        broadcast(new DiagramaSent($diagrama))->toOthers();
        return response()->json(['msm' => 'msmsms'], 200);
    }

    public function edit(Diagrama $diagrama)
    {
        return view('diagramas.edit', compact('diagrama'));
    }

    public function update(Request $request, Diagrama $diagrama)
    {
        try {
            $diagrama->nombre = $request->nombre;
            $diagrama->descripcion = $request->descripcion;
            $diagrama->tipo = $request->tipo;
            /* dd($request->url); */
            /* dd($diagrama->contenido); */
            $fp = fopen($request->url, "r");
            $text = "";
            $linea = "";
            while (!feof($fp)) {
                $diagrama->contenido = fgets($fp);
            }
            $diagrama->update();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
        return redirect()->route('diagramas.index', $diagrama->proyecto_id)->with('message', 'Se edito la inf del diagrama de manera correcta');
    }

    public function usuarios(Diagrama $diagrama)
    {
        $usuarios = $diagrama->proyecto->usuarios;
        return view('diagramas.usuarios', compact('diagrama', 'usuarios'));
    }

    public function agregar(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                DB::table('user_diagramas')->insert([
                    'user_id' => $request->user_id,
                    'diagrama_id' => $request->diagrama_id
                ]);
            });
            DB::commit();
            return redirect()->back()->with('message', 'Se agrego el usuario correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    public function banear(Request $request, Diagrama $diagrama)
    {
        try {
            $user = User::find($request->user_id);
            $relacion = Auth::user()->user_diagramas()->where('diagrama_id', $diagrama->id)->first();
            $rel = User_diagrama::find($relacion->id);
            $rel->delete();
            return redirect()->back()->with('message', 'Se removio al usuario del diagrama: ' . $diagrama->nombre);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    
    

    

    public function objeto($diagrama, $i)
    {
        $objeto = '<Row>
        <Column name="Object_ID" value="' . $i . '" />
        <Column name="Object_Type" value="Class" />
        <Column name="Diagram_ID" value="0" />
        <Column name="Name" value="' . $diagrama->attrs->headerText->text . '" />
        <Column name="Author" value="pedri" />
        <Column name="Version" value="1.0" />
        <Column name="Package_ID" value="3" />
        <Column name="NType" value="0" />
        <Column name="Complexity" value="1" />
        <Column name="Effort" value="0" />
        <Column name="Backcolor" value="-1" />
        <Column name="BorderStyle" value="0" />
        <Column name="BorderWidth" value="-1" />
        <Column name="Fontcolor" value="-1" />
        <Column name="Bordercolor" value="-1" />
        <Column name="CreatedDate" value="2022-12-04 18:19:13" />
        <Column name="ModifiedDate" value="2022-12-04 18:31:11" />
        <Column name="Status" value="Proposed" />
        <Column name="Abstract" value="0" />
        <Column name="Tagged" value="0" />
        <Column name="PDATA4" value="0" />
        <Column name="GenType" value="PHP" />
        <Column name="Phase" value="1.0" />
        <Column name="Scope" value="Public" />
        <Column name="Classifier" value="0" />
        <Column name="ea_guid" value="{' . $diagrama->id . '}" />
        <Column name="ParentID" value="0" />
        <Column name="IsRoot" value="FALSE" />
        <Column name="IsLeaf" value="FALSE" />
        <Column name="IsSpec" value="FALSE" />
        <Column name="IsActive" value="FALSE" />
        <Extension Package_ID="{EC8004E0-A94E-4205-9A63-6F87F6D67F1F}" />
        </Row>';
        return $objeto;
    }

    public function attribute($diagrama, $i)
    {
        $atributo = '<Row>
        <Column name="Object_ID" value="' . $i . '" />
        <Column name="Name" value="' . $diagrama->attrs->subHeaderText->text . '" />
        <Column name="Scope" value="Public" />
        <Column name="Containment" value="Not Specified" />
        <Column name="IsStatic" value="0" />
        <Column name="IsCollection" value="0" />
        <Column name="IsOrdered" value="0" />
        <Column name="AllowDuplicates" value="0" />
        <Column name="LowerBound" value="1" />
        <Column name="UpperBound" value="1" />
        <Column name="ID" value="' . $i . '" />
        <Column name="Pos" value="0" />
        <Column name="Classifier" value="0" />
        <Column name="ea_guid" value="{' . $diagrama->id . '}" />
        <Column name="StyleEx" value="volatile=0;" />
        <Extension Object_ID="{' . $diagrama->id . '}" />
        </Row>';
        return $atributo;
    }

    public function operation($diagrama, $i)
    {
        $operative = '<Row>
        <Column name="OperationID" value="' . $i . '" />
        <Column name="Object_ID" value="' . $i . '" />
        <Column name="Name" value="' . $diagrama->attrs->contentText->text . '" />
        <Column name="Scope" value="Public" />
        <Column name="Concurrency" value="Sequential" />
        <Column name="Pos" value="0" />
        <Column name="Pure" value="FALSE" />
        <Column name="Classifier" value="0" />
        <Column name="IsRoot" value="FALSE" />
        <Column name="IsLeaf" value="FALSE" />
        <Column name="IsQuery" value="FALSE" />
        <Column name="ea_guid" value="{0B668E21-C82D-4fe2-A263-F76A0189C4DC}" />
        <Extension Object_ID="{' . $diagrama->id . '}" />
        </Row>';
        return $operative;
    }

    public function position($diagrama, $i)
    {
        $position = '<Row>
        <Column name="Diagram_ID" value="12" />
        <Column name="Object_ID" value="' . $i . '" />
        <Column name="RectTop" value="-' . ((int) ($diagrama->position->y)) . '" />
        <Column name="RectLeft" value="' . ((int) $diagrama->position->x) . '" />
        <Column name="RectRight" value="' . ((int) $diagrama->position->x + $diagrama->size->width + 10) . '" />
        <Column name="RectBottom" value="-' . ((int) ($diagrama->position->y + $diagrama->size->height + 10)) . '" />
        <Column name="Sequence" value="' . $i . '" />
        <Column name="ObjectStyle" value="DUID=4317C271;" />
        <Column name="Instance_ID" value="' . $i . '" />
        <Extension Diagram_ID="{54BA53B2-4E2C-4c7c-8FFC-F0897ABF1B34}" Object_ID="{' . $diagrama->id . '}" />
        </Row>';
        return $position;
    }

    public function conector($diagrama, $i)
    {
        $label = '';
        if (count($diagrama->labels) > 0) {
            $label = $diagrama->labels[0]->attrs->text->text;
        }
        $coneccion = '<Row>
        <Column name="Connector_ID" value="' . $i . '" />
        <Column name="Name" value="' . $label . '" />
        <Column name="Direction" value="Source -&gt; Destination" />
        <Column name="Connector_Type" value="Dependency" />
        <Column name="SourceAccess" value="Public" />
        <Column name="DestAccess" value="Public" />
        <Column name="SourceContainment" value="Unspecified" />
        <Column name="SourceIsAggregate" value="0" />
        <Column name="SourceIsOrdered" value="0" />
        <Column name="DestContainment" value="Unspecified" />
        <Column name="DestIsAggregate" value="0" />
        <Column name="DestIsOrdered" value="0" />
        <Column name="Start_Object_ID" value="50" />
        <Column name="End_Object_ID" value="51" />
        <Column name="Start_Edge" value="0" />
        <Column name="End_Edge" value="0" />
        <Column name="PtStartX" value="0" />
        <Column name="PtStartY" value="0" />
        <Column name="PtEndX" value="0" />
        <Column name="PtEndY" value="0" />
        <Column name="SeqNo" value="0" />
        <Column name="HeadStyle" value="0" />
        <Column name="LineStyle" value="0" />
        <Column name="RouteStyle" value="3" />
        <Column name="IsBold" value="0" />
        <Column name="LineColor" value="-1" />
        <Column name="PDATA5" value="SX=0;SY=0;EX=0;EY=0;" />
        <Column name="DiagramID" value="0" />
        <Column name="ea_guid" value="{' . $diagrama->id . '}" />
        <Column name="SourceIsNavigable" value="FALSE" />
        <Column name="DestIsNavigable" value="TRUE" />
        <Column name="IsRoot" value="FALSE" />
        <Column name="IsLeaf" value="FALSE" />
        <Column name="IsSpec" value="FALSE" />
        <Column name="SourceChangeable" value="none" />
        <Column name="DestChangeable" value="none" />
        <Column name="SourceTS" value="instance" />
        <Column name="DestTS" value="instance" />
        <Column name="IsSignal" value="FALSE" />
        <Column name="IsStimulus" value="FALSE" />
        <Column name="Target2" value="-1263619272" />
        <Column name="SourceStyle" value="Union=0;Derived=0;AllowDuplicates=0;Owned=0;Navigable=Non-Navigable;" />
        <Column name="DestStyle" value="Union=0;Derived=0;AllowDuplicates=0;Owned=0;Navigable=Navigable;" />
        <Extension Start_Object_ID="{' . $diagrama->source->id . '}" End_Object_ID="{' . $diagrama->target->id . '}" />
        </Row>';
        return $coneccion;
    }

    public function extension($diagrama, $i)
    {
        $extension = '<Row>
        <Column name="DiagramID" value="12" />
        <Column name="ConnectorID" value="' . $i . '" />
        <Column name="Geometry" value="SX=0;SY=0;EX=0;EY=0;EDGE=2;$LLB=;LLT=;LMT=CX=20:CY=14:OX=0:OY=0:HDN=0:BLD=0:ITA=0:UND=0:CLR=-1:ALN=1:DIR=0:ROT=0;LMB=;LRT=;LRB=;IRHS=;ILHS=;" />
        <Column name="Style" value="Mode=3;EOID=45DF43AE;SOID=9C7A8367;Color=-1;LWidth=0;" />
        <Column name="Hidden" value="FALSE" />
        <Column name="Instance_ID" value="' . $i . '" />
        <Extension DiagramID="{54BA53B2-4E2C-4c7c-8FFC-F0897ABF1B34}" ConnectorID="{' . $diagrama->id . '}" />
        </Row>';
        return $extension;
    }

    public function boundary($diagrama, $i)
    {
        $boundary = '<Row>
        <Column name="Object_ID" value="' . $i . '" />
        <Column name="Object_Type" value="Boundary" />
        <Column name="Diagram_ID" value="0" />
        <Column name="Name" value="' . $diagrama->attrs->headerText->text . $diagrama->attrs->subHeaderText->text . '" />
        <Column name="Author" value="pedri" />
        <Column name="Version" value="1.0" />
        <Column name="Package_ID" value="3" />
        <Column name="NType" value="0" />
        <Column name="Complexity" value="1" />
        <Column name="Effort" value="0" />
        <Column name="Backcolor" value="-1" />
        <Column name="BorderStyle" value="2" />
        <Column name="BorderWidth" value="-1" />
        <Column name="Fontcolor" value="-1" />
        <Column name="Bordercolor" value="-1" />
        <Column name="CreatedDate" value="2022-12-06 11:51:38" />
        <Column name="ModifiedDate" value="2022-12-06 11:56:08" />
        <Column name="Status" value="Proposed" />
        <Column name="Abstract" value="0" />
        <Column name="Tagged" value="0" />
        <Column name="PDATA1" value="1" />
        <Column name="PDATA2" value="1" />
        <Column name="PDATA3" value="0" />
        <Column name="GenType" value="PHP" />
        <Column name="Phase" value="1.0" />
        <Column name="Scope" value="Public" />
        <Column name="Classifier" value="0" />
        <Column name="ea_guid" value="{' . $diagrama->id . '}" />
        <Column name="ParentID" value="0" />
        <Column name="IsRoot" value="FALSE" />
        <Column name="IsLeaf" value="FALSE" />
        <Column name="IsSpec" value="FALSE" />
        <Column name="IsActive" value="FALSE" />
        <Extension Package_ID="{EC8004E0-A94E-4205-9A63-6F87F6D67F1F}" />
        </Row>';
        return $boundary;
    }
    public function descargar(Diagrama $diagrama)
    {
        $nombre = $diagrama->nombre;
        $contenido = json_decode($diagrama->contenido);
       
        $cell = $contenido->cells;                
        $sql = 'create database ' .$nombre. ';'.PHP_EOL.' use ' .$nombre. ';'.PHP_EOL.PHP_EOL;

        
        for ($i = 0; $i < count($cell); $i++) {
            $primary = '';
            $c = 0;
            if ($cell[$i]->type == 'uml.Class' ) {
                if(count($cell[$i]->attributes) != 0){
                    $sql .= 'create table '. $cell[$i]->name. '( '.PHP_EOL;
                    
                    $atri = $cell[$i]->attributes;
                    for ($j = 0; $j < count($atri); $j++) {   

                        if(str_contains($atri[$j], 'Pk')|| str_contains($atri[$j], 'PK')|| str_contains($atri[$j], 'pk')){
                            if($c == 0){
                                $pieces = explode(" : ", $atri[$j]);
                                $primary = $pieces[0] ;
                                $c++;
                            }else{
                                $pieces = explode(" : ", $atri[$j]);
                                $primary .= ', '.$pieces[0] ;
                            }
                                
                        }   

                        if(str_contains($atri[$j], 'Fk')|| str_contains($atri[$j], 'FK')|| str_contains($atri[$j], 'fk')){
                            if($j == count($atri)-1){
                                $pieces = explode(" :", $atri[$j]);
                                if(str_contains($pieces[0], '_')){
                                    $foranea = explode("_", $pieces[0]);
                                    $sql .= ' '.$pieces[0]. ' ' .$pieces[1].' '.PHP_EOL.'primary key(' .$primary.'), '.PHP_EOL.' FOREIGN KEY ('.$pieces[0].') REFERENCES '.$foranea[1].'('.$foranea[0].') ON DELETE CASCADE  ON UPDATE CASCADE);'.PHP_EOL;
                                }else{
                                    $sql .= 'foranea mal definida'.PHP_EOL;
                                }
                            }else{
                                $pieces = explode(" : ", $atri[$j]);
                                if(str_contains($pieces[0], '_')){
                                    $foranea = explode("_", $pieces[0]);
                                    $sql .= ' ' .$pieces[0].' ' .$pieces[1]. ','.PHP_EOL.' FOREIGN KEY ('.$pieces[0].') REFERENCES '.$foranea[1].'('.$foranea[0].') ON DELETE CASCADE ON UPDATE CASCADE);'.PHP_EOL;
                                }else{
                                    $sql .= 'foranea mal definida'.PHP_EOL;
                                }    
                            }

                        }else{
                            if($j == count($atri)-1){
                                $pieces = explode(" ", $atri[$j]);
                                $sql .= ' '.$pieces[0]. ' ' .$pieces[2].', '.PHP_EOL.' primary key(' .$primary.') '.PHP_EOL.' );'.PHP_EOL;
                            }else{
                                $pieces = explode(" ", $atri[$j]);
                                $sql .= ' ' .$pieces[0].' ' .$pieces[2]. ','.PHP_EOL;
                            }
                        }            
                    }
                }
            } 
        }

        $path = 'script.sql';
        $th = fopen("script.sql", "w");
        fclose($th);
        $ar = fopen("script.sql", "a") or die("Error al crear");
        fwrite($ar, $sql);
        fclose($ar);
        return response()->download($path);
    }
}
