Imports System.Data.SqlClient
Imports System.Windows.Forms

Public Class DBModel


    Public Shared BezoekerContext As New E2EOefDBEntities
    Public Shared BezoekerModel As New Bezoeker

    Public Shared Sub InsertRecord _
       (ingelogdeBezoeker As String, voornaam As String, achternaam As String, email As String, land As String _
        , telefoon As String, onderwerp As String, bericht As String, creationdate As String)

        Dim bezoekerAlreadyAdded = BezoekerContext.Bezoekers.Where(Function(n) n.Email = email).SingleOrDefault

        If bezoekerAlreadyAdded Is Nothing Then

            With BezoekerModel
                .Ingelogde_Bezoeker = ingelogdeBezoeker
                .Voornaam = voornaam
                .Achternaam = achternaam
                .Email = email
                .Land = land
                .Telefoon = telefoon
                .Onderwerp = onderwerp
                .Bericht = bericht
                .CreationDate = creationdate
            End With

            BezoekerContext.Bezoekers.Add(BezoekerModel)
            BezoekerContext.SaveChanges()
        Else
            MsgBox("bezoeker already added to database!!!")
        End If
    End Sub

    Public Shared Sub UpdateRecord(id As Integer, ingelogdGebruiker As String, voornaam As String, achternaam As String _
                                         , email As String, land As String, telefoon As String, onderwerp As String, bericht As String _
                                         , creationdate As String)

        ' Using db As New E2EOefDBEntities
        Dim BezoekerToUpdate = BezoekerContext.Bezoekers.Where(Function(i) i.Id = id).SingleOrDefault

        'End Using

        If (BezoekerToUpdate Is Nothing) Then
            MsgBox("The bezoeker you want to update, doesn't exist")
        Else
            With BezoekerToUpdate
                .Ingelogde_Bezoeker = ingelogdGebruiker
                .Voornaam = voornaam
                .Achternaam = achternaam
                .Email = email
                .Land = land
                .Telefoon = telefoon
                .Onderwerp = onderwerp
                .Bericht = bericht
                .CreationDate = creationdate
            End With

            BezoekerContext.SaveChanges()

        End If

    End Sub

    Public Shared Sub DeleteRecord(id As Integer)

        Dim BezoekerToDelete = BezoekerContext.Bezoekers.Where(Function(i) i.Id = id).FirstOrDefault

        If (BezoekerToDelete Is Nothing) Then
            MsgBox("The bezoeker you want to delete, doesn't exist")
        Else

            BezoekerContext.Bezoekers.Remove(BezoekerToDelete)
            BezoekerContext.SaveChanges()

            MsgBox("Succesfully deleted record", MsgBoxStyle.Information)
        End If
    End Sub





End Class
