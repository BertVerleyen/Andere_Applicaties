Public Class Car
    Public Property Model As String
    Public Property Color As String

    Public Sub New(ByVal aniidiot As String)

    End Sub

    Public Function GetValue() As Integer
        Dim val As Integer

        If Me.Model = "hihihi" Then
            val = 100
        End If

        Return val
    End Function

    Public Shared Sub AddToInventory(ByVal valuezeker As String)
        'shared = static C#


    End Sub

End Class
